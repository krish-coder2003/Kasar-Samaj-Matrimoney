<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileInteractionController extends Controller
{
    public function toggleLike(Request $request, $userId)
    {
        $currentUser = Auth::user();

        if (!$currentUser->is_premium) {
            return response()->json([
                'success' => false, 
                'message' => 'Liking profiles is a premium feature. Please upgrade.'
            ]);
        }

        if ($currentUser->id == $userId) {
            return response()->json(['success' => false, 'message' => 'You cannot like yourself.']);
        }

        $existingLike = Like::where('user_id', $currentUser->id)
                            ->where('liked_user_id', $userId)
                            ->first();

        if ($existingLike) {
            $existingLike->delete();
            return response()->json(['success' => true, 'liked' => false, 'message' => 'Profile unliked.']);
        } else {
            Like::create([
                'user_id' => $currentUser->id,
                'liked_user_id' => $userId
            ]);
            return response()->json(['success' => true, 'liked' => true, 'message' => 'Profile liked!']);
        }
    }

    public function getLikes()
    {
        $currentUser = Auth::user();

        if (!$currentUser->is_premium) {
            return redirect()->route('plans')->with('error', 'Viewing who liked your profile is a premium feature.');
        }

        $likedBy = Like::where('liked_user_id', $currentUser->id)
                       ->with('user.profile')
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('profile.likes', compact('likedBy'));
    }

    public function trackView($userId)
    {
        $viewerId = Auth::id();
        if ($viewerId == $userId) return response()->json(['success' => false]);

        // Record the view
        \App\Models\ProfileView::create([
            'viewer_id' => $viewerId,
            'viewed_id' => $userId
        ]);

        // Create Notification (if not already notified recently for the same viewer)
        $alreadyNotified = \App\Models\Notification::where('user_id', $userId)
            ->where('actor_id', $viewerId)
            ->where('type', 'profile_view')
            ->where('is_read', false)
            ->exists();

        if (!$alreadyNotified) {
            \App\Models\Notification::create([
                'user_id' => $userId,
                'type' => 'profile_view',
                'message' => 'Someone viewed your profile!',
                'actor_id' => $viewerId,
                'is_read' => false
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function getVisitors()
    {
        $currentUser = Auth::user();
        
        // Fetch visitors, unique by viewer_id to show distinct people
        $visitors = \App\Models\ProfileView::where('viewed_id', $currentUser->id)
            ->with(['viewer.profile'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('viewer_id');

        return view('profile.visitors', compact('visitors'));
    }

    public function getNotifications()
    {
        $notifications = \App\Models\Notification::where('user_id', Auth::id())
            ->with(['actor.profile'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        return response()->json([
            'success' => true,
            'notifications' => $notifications,
            'unread_count' => \App\Models\Notification::where('user_id', Auth::id())->where('is_read', false)->count()
        ]);
    }

    public function markNotificationsRead()
    {
        \App\Models\Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
            
        return response()->json(['success' => true]);
    }
}
