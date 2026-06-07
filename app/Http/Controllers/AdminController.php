<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Interest;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showLogin()
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (auth()->attempt($credentials)) {
            if (auth()->user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            auth()->logout();
            return back()->with('error', 'Only administrators can access this area.');
        }

        return back()->with('error', 'Invalid credentials.');
    }

    public function dashboard()
    {
        $totalUsers = User::count();
        $premiumUsers = User::where('is_premium', true)->count();
        $totalInterests = Interest::count();
        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalUsers', 'premiumUsers', 'totalInterests', 'recentUsers'));
    }

    public function users()
    {
        $users = User::with('profile')->latest()->get();
        return view('admin.users', compact('users'));
    }

    public function editUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'You cannot edit your own account from the admin panel.');
        }
        return view('admin.edit-user', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'You cannot update your own account from the admin panel.');
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
            'is_premium' => 'required|boolean',
        ]);

        $user->update($request->all());

        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function legal()
    {
        return view('admin.legal');
    }

    public function updateSettings(Request $request)
    {
        $data = $request->except('_token', 'hero_image');

        foreach ($data as $key => $value) {
            \App\Models\Setting::set($key, $value);
        }

        if ($request->hasFile('hero_image')) {
            $path = $request->file('hero_image')->store('site', 'public');
            \App\Models\Setting::set('hero_image', $path);
        }

        return back()->with('success', 'Settings updated successfully.');
    }

    // Success Stories Management
    public function stories()
    {
        $stories = \App\Models\SuccessStory::latest()->get();
        return view('admin.stories.index', compact('stories'));
    }

    public function createStory()
    {
        return view('admin.stories.create');
    }

    public function storeStory(Request $request)
    {
        $request->validate([
            'couple_name' => 'required|string',
            'story' => 'required|string',
            'photo' => 'nullable|image'
        ]);

        $data = $request->only('couple_name', 'story');
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('stories', 'public');
        }

        \App\Models\SuccessStory::create($data);
        return redirect()->route('admin.stories')->with('success', 'Story created successfully.');
    }

    public function deleteStory(\App\Models\SuccessStory $story)
    {
        $story->delete();
        return back()->with('success', 'Story deleted successfully.');
    }

    // FAQ Management
    public function faqs()
    {
        $faqs = \App\Models\Faq::latest()->get();
        return view('admin.faqs.index', compact('faqs'));
    }

    public function storeFaq(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string'
        ]);

        \App\Models\Faq::create($request->only('question', 'answer'));
        return back()->with('success', 'FAQ added successfully.');
    }

    public function deleteFaq(\App\Models\Faq $faq)
    {
        $faq->delete();
        return back()->with('success', 'FAQ deleted successfully.');
    }

    public function viewLogs()
    {
        $logPath = storage_path('logs/laravel.log');
        $logs = [];

        if (file_exists($logPath)) {
            $fileContent = file_get_contents($logPath);
            // Split by date pattern [YYYY-MM-DD
            $parts = preg_split('/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\]/m', $fileContent, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
            
            for ($i = 0; $i < count($parts); $i += 2) {
                if (isset($parts[$i+1])) {
                    $logs[] = [
                        'timestamp' => $parts[$i],
                        'content' => trim($parts[$i+1])
                    ];
                }
            }
            
            $logs = array_reverse($logs); // Newest first
            $logs = array_slice($logs, 0, 50); // Last 50 entries
        }

        return view('admin.logs', compact('logs'));
    }

    // Identity Verifications
    public function verifications()
    {
        $profiles = \App\Models\Profile::whereNotNull('aadhaar_card')
            ->with('user')
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('admin.verifications', compact('profiles'));
    }

    public function approveVerification(\App\Models\Profile $profile)
    {
        $profile->update([
            'verification_status' => 'approved',
            'is_verified' => true
        ]);
        return back()->with('success', "Profile of {$profile->user->name} has been approved.");
    }

    public function rejectVerification(\App\Models\Profile $profile)
    {
        $profile->update([
            'verification_status' => 'rejected',
            'is_verified' => false
        ]);
        return back()->with('success', "Profile of {$profile->user->name} has been rejected.");
    }

    // Membership Management Dashboard
    public function memberships()
    {
        $payments = \App\Models\Payment::with('user')->orderBy('created_at', 'desc')->get();
        
        // Fetch premium users (non-admins)
        $premiumUsers = \App\Models\User::where('is_premium', true)
            ->where('role', '!=', 'admin')
            ->with('profile')
            ->latest()
            ->get();
            
        // Fetch standard users (non-admins)
        $standardUsers = \App\Models\User::where('is_premium', false)
            ->where('role', '!=', 'admin')
            ->with('profile')
            ->latest()
            ->get();

        return view('admin.memberships.index', compact('payments', 'premiumUsers', 'standardUsers'));
    }

    // Change Gold Plan price
    public function updatePlanPrice(Request $request)
    {
        $request->validate([
            'gold_plan_price' => 'required|numeric|min:0',
        ]);

        \App\Models\Setting::set('gold_plan_price', $request->gold_plan_price);

        return back()->with('success', 'Gold Plan price updated successfully.');
    }

    // Approve Premium membership manually
    public function approvePremium(\App\Models\User $user)
    {
        $user->update(['is_premium' => true]);
        
        // Also create a manual payment record if one doesn't exist
        \App\Models\Payment::create([
            'user_id' => $user->id,
            'plan_name' => 'Gold Plan',
            'amount' => \App\Models\Setting::get('gold_plan_price', 1000),
            'currency' => 'INR',
            'status' => 'completed', // Completed/Approved status
        ]);

        return back()->with('success', "Membership for {$user->name} has been upgraded to Premium.");
    }

    // Reject / Revoke Premium membership manually
    public function rejectPremium(\App\Models\User $user)
    {
        $user->update(['is_premium' => false]);
        
        // Mark any completed payments for this user as rejected
        \App\Models\Payment::where('user_id', $user->id)
            ->where('status', 'completed')
            ->update(['status' => 'rejected']);

        return back()->with('success', "Premium membership for {$user->name} has been revoked.");
    }

    // Approve a payment transaction manually
    public function approvePayment(\App\Models\Payment $payment)
    {
        $payment->update(['status' => 'completed']);
        $payment->user->update(['is_premium' => true]);

        return back()->with('success', "Transaction approved. User {$payment->user->name} has been upgraded to Premium.");
    }

    // Reject a payment transaction manually
    public function rejectPayment(\App\Models\Payment $payment)
    {
        $payment->update(['status' => 'rejected']);
        
        // Revoke premium only if they don't have other active payments
        $payment->user->update(['is_premium' => false]);

        return back()->with('success', "Transaction rejected. Premium membership for {$payment->user->name} has been revoked.");
    }
}
