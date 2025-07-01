<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Events\MessageSent;

class ChatController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())
            ->whereNotIn('role', ['logistics', 'procurement'])
            ->get();
        // Add a virtual 'Group' user at the top
        $groupUser = (object)[
            'id' => 'group',
            'name' => 'Group',
            'last_seen' => null,
            'role' => null
        ];
        $users->prepend($groupUser);
        // Get unread message counts for each user
        $unreadCounts = [];
        foreach ($users as $user) {
            if ($user->id === 'group') {
                $unreadCounts[$user->id] = \App\Models\Message::where('group', 'Group')
                    ->where('sender_id', '!=', Auth::id())
                    ->where('is_read', false)
                    ->count();
            } else {
                $unreadCounts[$user->id] = \App\Models\Message::where('sender_id', $user->id)
                    ->where('receiver_id', Auth::id())
                    ->where('is_read', false)
                    ->count();
            }
        }
        return view('chat.index', compact('users', 'unreadCounts'));
    }

    public function fetchMessages(Request $request, $userId)
    {
        if ($userId === 'group') {
            $messages = Message::where('group', 'Group')->orderBy('created_at')->get();
            // Mark all group messages as read for this user
            Message::where('group', 'Group')
                ->where('sender_id', '!=', Auth::id())
                ->where('is_read', false)
                ->update(['is_read' => true]);
        } else {
            $messages = Message::where(function ($q) use ($userId) {
                $q->where('sender_id', Auth::id())
                  ->where('receiver_id', $userId);
            })->orWhere(function ($q) use ($userId) {
                $q->where('sender_id', $userId)
                  ->where('receiver_id', Auth::id());
            })->orderBy('created_at')->get();
            // Mark messages as read where the current user is the receiver
            Message::where('sender_id', $userId)
                ->where('receiver_id', Auth::id())
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }
        // Attach reply message data if present
        $messages->load('replyMessage');
        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'nullable|exists:users,id',
            'message' => 'nullable|string',
            'file' => 'nullable|file|max:10240',
            'group' => 'nullable|string',
            'reply_to' => 'nullable|integer|exists:messages,id',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('chat_files', 'public');
        }

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->group === 'Group' ? null : $request->receiver_id,
            'group' => $request->group === 'Group' ? 'Group' : null,
            'message' => $request->message,
            'file' => $filePath,
            'reply_to' => $request->reply_to,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }

    public function editMessage(Request $request, $id)
    {
        $message = Message::findOrFail($id);
        if ($message->sender_id !== Auth::id()) {
            abort(403);
        }
        $request->validate([
            'message' => 'required|string',
        ]);
        $message->message = $request->message;
        $message->edited_at = now();
        $message->save();
        return response()->json($message);
    }

    public function deleteMessage($id)
    {
        $message = Message::findOrFail($id);
        if ($message->sender_id !== Auth::id()) {
            abort(403);
        }
        $message->delete();
        return response()->json(['success' => true]);
    }

    public function typing(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
        ]);
        broadcast(new \App\Events\UserTyping(Auth::id(), $request->receiver_id))->toOthers();
        return response()->json(['success' => true]);
    }
} 