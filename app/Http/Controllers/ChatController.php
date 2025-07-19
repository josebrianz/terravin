<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;

class ChatController extends Controller
{
    // Show user list
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get()->map(function($user) {
            $latestMessage = \App\Models\ChatMessage::where(function($q) use ($user) {
                $q->where('sender_id', Auth::id())->where('receiver_id', $user->id);
            })->orWhere(function($q) use ($user) {
                $q->where('sender_id', $user->id)->where('receiver_id', Auth::id());
            })->orderByDesc('created_at')->first();
            $unreadCount = \App\Models\ChatMessage::where('sender_id', $user->id)
                ->where('receiver_id', Auth::id())
                ->whereNull('read_at')
                ->count();
            $user->latestMessage = $latestMessage;
            $user->latestTime = $latestMessage ? $latestMessage->created_at->format('H:i A') : '';
            $user->unreadCount = $unreadCount;
            return $user;
        });
        return view('chat.index', compact('users'));
    }

    // Show conversation with a user
    public function show($userId)
    {
        $other = User::findOrFail($userId);
        $users = User::where('id', '!=', Auth::id())->get()->map(function($user) {
            $latestMessage = \App\Models\ChatMessage::where(function($q) use ($user) {
                $q->where('sender_id', Auth::id())->where('receiver_id', $user->id);
            })->orWhere(function($q) use ($user) {
                $q->where('sender_id', $user->id)->where('receiver_id', Auth::id());
            })->orderByDesc('created_at')->first();
            $unreadCount = \App\Models\ChatMessage::where('sender_id', $user->id)
                ->where('receiver_id', Auth::id())
                ->whereNull('read_at')
                ->count();
            $user->latestMessage = $latestMessage;
            $user->latestTime = $latestMessage ? $latestMessage->created_at->format('H:i A') : '';
            $user->unreadCount = $unreadCount;
            return $user;
        });
        $messages = ChatMessage::where(function($q) use ($userId) {
                $q->where('sender_id', Auth::id())->where('receiver_id', $userId);
            })->orWhere(function($q) use ($userId) {
                $q->where('sender_id', $userId)->where('receiver_id', Auth::id());
            })->orderBy('created_at')->get();
        if (request()->ajax() || request()->wantsJson()) {
            $html = view('chat._conversation', compact('other', 'users', 'messages'))->render();
            return response()->json(['success' => true, 'html' => $html]);
        }
        return view('chat.show', compact('other', 'users', 'messages'));
    }

    // Send a message
    public function store(Request $request, $userId)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
            'attachment' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf,doc,docx|max:5120',
        ]);

        $attachmentPath = null;
        $attachmentType = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $attachmentPath = $file->store('chat_attachments', 'public');
            $attachmentType = $file->getClientMimeType();
        }

        // Only require message if no file is attached
        if (!$request->filled('message') && !$attachmentPath) {
            return response()->json(['success' => false, 'error' => 'Message or attachment required.'], 422);
        }

        $message = ChatMessage::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $userId,
            'message' => $request->message,
            'attachment_path' => $attachmentPath,
            'attachment_type' => $attachmentType,
        ]);
        // Broadcast the event
        event(new MessageSent($message, Auth::user(), $userId));
        if ($request->ajax() || $request->wantsJson()) {
            $message->load('sender');
            $html = view('chat._message', compact('message'))->render();
            return response()->json(['success' => true, 'html' => $html]);
        }
        return redirect()->route('chat.show', $userId);
    }

    public function deleteMessage($id)
    {
        $message = ChatMessage::findOrFail($id);
        if ($message->sender_id !== auth()->id()) {
            abort(403);
        }
        $message->delete();
        // Optionally broadcast a MessageDeleted event for real-time removal
        return response()->json(['success' => true]);
    }

    public function editMessage(Request $request, $id)
    {
        $request->validate(['message' => 'required|string|max:2000']);
        $message = ChatMessage::findOrFail($id);
        if ($message->sender_id !== auth()->id()) {
            abort(403);
        }
        $message->message = $request->message;
        $message->save();
        // Optionally broadcast a MessageEdited event for real-time update
        return response()->json(['success' => true, 'message' => $message->message]);
    }
}
