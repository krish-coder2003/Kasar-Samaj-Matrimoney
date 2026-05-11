<?php

namespace App\Http\Controllers;

use App\Models\Interest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InterestController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $receivedInterests = Interest::where('receiver_id', $user->id)
                                    ->with('sender.profile')
                                    ->latest()
                                    ->get();

        $sentInterests = Interest::where('sender_id', $user->id)
                                 ->with('receiver.profile')
                                 ->latest()
                                 ->get();

        return view('profile.interests', compact('receivedInterests', 'sentInterests'));
    }

    public function update(Request $request, Interest $interest)
    {
        if ($interest->receiver_id != Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $request->validate(['status' => 'required|in:accepted,declined']);
        
        $interest->update(['status' => $request->status]);

        return back()->with('success', 'Interest status updated!');
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id'
        ]);

        $senderId = Auth::id();
        $receiverId = $request->receiver_id;

        if ($senderId == $receiverId) {
            return response()->json(['success' => false, 'message' => 'You cannot send interest to yourself.']);
        }

        // Check if I already sent an interest to them
        $existing = Interest::where('sender_id', $senderId)
                            ->where('receiver_id', $receiverId)
                            ->first();

        if ($existing) {
            return response()->json(['success' => false, 'message' => 'Interest already sent to this profile.']);
        }

        Interest::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'status' => 'pending'
        ]);

        return response()->json(['success' => true, 'message' => 'Interest sent successfully!']);
    }
    public function destroy(Interest $interest)
    {
        if ($interest->sender_id != Auth::id() && $interest->receiver_id != Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $interest->delete();
        return back()->with('success', 'Interest discarded.');
    }
}
