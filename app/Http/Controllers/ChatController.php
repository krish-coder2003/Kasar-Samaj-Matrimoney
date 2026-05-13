<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Models\Interest;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function index($userId = null)
    {
        $currentUser = Auth::user();

        if (!$currentUser->is_premium) {
            return redirect()->route('plans')->with('error', 'Chat is a premium feature. Please upgrade.');
        }

        // Update online status
        $currentUser->update(['last_seen_at' => now()]);

        // Fetch contacts (Accepted interests)
        $interests = Interest::where(function ($q) use ($currentUser) {
            $q->where('sender_id', $currentUser->id)->orWhere('receiver_id', $currentUser->id);
        })->where('status', 'accepted')->get();

        $contactIds = [];
        foreach ($interests as $interest) {
            $contactIds[] = $interest->sender_id == $currentUser->id ? $interest->receiver_id : $interest->sender_id;
        }

        $contacts = User::whereIn('id', $contactIds)->with('profile')->get();

        $activeChatUser = null;
        $messages = [];

        if ($userId) {
            if (!in_array($userId, $contactIds)) {
                return redirect()->route('chat.index')->with('error', 'Connection not accepted yet.');
            }
            $activeChatUser = User::with('profile')->findOrFail($userId);

            $messages = Message::where(function ($q) use ($currentUser, $userId) {
                $q->where('sender_id', $currentUser->id)->where('receiver_id', $userId);
            })->orWhere(function ($q) use ($currentUser, $userId) {
                $q->where('sender_id', $userId)->where('receiver_id', $currentUser->id);
            })->orderBy('created_at', 'asc')->get();

            // Mark as read
            Message::where('sender_id', $userId)->where('receiver_id', $currentUser->id)->update(['is_read' => true]);
        }

        return view('chat.index', compact('contacts', 'activeChatUser', 'messages'));
    }

    public function sendMessage(Request $request, $userId)
    {
        $currentUser = Auth::user();

        if (!$currentUser->is_premium) {
            return response()->json(['success' => false, 'message' => 'Premium required.']);
        }

        $request->validate([
            'message' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,webp,heic|max:20480'
        ]);

        $filePath = null;
        $fileType = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('chat_files', 'public');
            $fileType = $file->getClientOriginalExtension() == 'pdf' ? 'pdf' : 'image';
        }

        if (!$request->message && !$filePath) {
            return response()->json(['success' => false, 'message' => 'Cannot send empty message.']);
        }

        $message = Message::create([
            'sender_id' => $currentUser->id,
            'receiver_id' => $userId,
            'message' => $request->message,
            'file_path' => $filePath,
            'file_type' => $fileType
        ]);

        try {
            // Diagnostic: Check if port 8080 is reachable
            $fp = @fsockopen('127.0.0.1', 8080, $errno, $errstr, 1);
            if (!$fp) {
                \Illuminate\Support\Facades\Log::warning("Diagnostic: Cannot reach Reverb port 8080. Error: $errstr");
            } else {
                fclose($fp);
            }

            broadcast(new MessageSent($message));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Broadcasting failed: ' . $e->getMessage());
        }

        return response()->json(['success' => true, 'message' => $message]);
    }

    public function fetchMessages($userId)
    {
        $currentUser = Auth::user();
        $currentUser->update(['last_seen_at' => now()]);

        $messages = Message::where(function ($q) use ($currentUser, $userId) {
            $q->where('sender_id', $currentUser->id)->where('receiver_id', $userId);
        })->orWhere(function ($q) use ($currentUser, $userId) {
            $q->where('sender_id', $userId)->where('receiver_id', $currentUser->id);
        })->orderBy('created_at', 'asc')->get();

        // Mark as read
        Message::where('sender_id', $userId)->where('receiver_id', $currentUser->id)->update(['is_read' => true]);

        return response()->json(['success' => true, 'messages' => $messages]);
    }
}