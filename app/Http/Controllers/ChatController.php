<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // List all users you can chat with (suppliers for customers, customers for suppliers)
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'Customer') {
            $users = User::where('role', 'Supplier')->get();
        } elseif ($user->role === 'Supplier') {
            $users = User::where('role', 'Customer')->get();
        } else {
            abort(403, 'Only suppliers and customers can use chat.');
        }
        return view('chat.index', compact('users'));
    }

    // Show chat with a specific user
    public function show($userId)
    {
        $user = Auth::user();
        $other = User::findOrFail($userId);
        // Only allow supplier-customer chat
        if (!in_array($user->role, ['Customer', 'Supplier']) ||
            !in_array($other->role, ['Customer', 'Supplier']) ||
            $user->role === $other->role) {
            abort(403, 'Chat only allowed between suppliers and customers.');
        }
        $messages = ChatMessage::where(function($q) use ($user, $other) {
            $q->where('sender_id', $user->id)->where('receiver_id', $other->id);
        })->orWhere(function($q) use ($user, $other) {
            $q->where('sender_id', $other->id)->where('receiver_id', $user->id);
        })->orderBy('created_at')->get();
        return view('chat.show', compact('other', 'messages'));
    }

    // Send a message
    public function store(Request $request, $userId)
    {
        $user = Auth::user();
        $other = User::findOrFail($userId);
        if (!in_array($user->role, ['Customer', 'Supplier']) ||
            !in_array($other->role, ['Customer', 'Supplier']) ||
            $user->role === $other->role) {
            abort(403, 'Chat only allowed between suppliers and customers.');
        }
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);
        ChatMessage::create([
            'sender_id' => $user->id,
            'receiver_id' => $other->id,
            'message' => $request->message,
        ]);
        return redirect()->route('chat.show', $other->id);
    }
}
