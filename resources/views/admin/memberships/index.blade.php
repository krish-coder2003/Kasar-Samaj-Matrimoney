@extends('layouts.admin')

@section('title', 'Membership & Payments')

@section('styles')
<style>
    .tabs-nav {
        display: flex;
        gap: 10px;
        margin-bottom: 2.5rem;
        border-bottom: 2px solid rgba(0, 0, 0, 0.05);
        padding-bottom: 0.5rem;
    }
    .tab-btn {
        background: none;
        border: none;
        padding: 0.8rem 1.5rem;
        font-family: inherit;
        font-size: 1.05rem;
        font-weight: 600;
        color: #888;
        cursor: pointer;
        position: relative;
        transition: 0.3s;
    }
    .tab-btn:hover {
        color: #800000;
    }
    .tab-btn.active {
        color: #800000;
    }
    .tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        right: 0;
        height: 3px;
        background: #800000;
        border-radius: 10px;
    }
    .tab-content {
        display: none;
    }
    .tab-content.active {
        display: block;
    }
    .plans-admin-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }
    .plan-admin-card {
        background: white;
        padding: 2.5rem;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        border: 1px solid rgba(0, 0, 0, 0.02);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .plan-admin-card.gold-border {
        border-top: 5px solid #D4AF37;
    }
    .plan-admin-card.free-border {
        border-top: 5px solid #888;
    }
    .price-input-group {
        display: flex;
        gap: 10px;
        margin-top: 1.5rem;
    }
    .price-input-group input {
        flex: 1;
        padding: 0.9rem;
        border: 2px solid #eee;
        border-radius: 10px;
        font-size: 1.1rem;
        font-weight: 700;
        color: #333;
        font-family: inherit;
    }
    .price-input-group input:focus {
        border-color: #800000;
        outline: none;
    }
    .price-input-group button {
        background: #800000;
        color: white;
        border: none;
        padding: 0 1.5rem;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 700;
        transition: 0.3s;
    }
    .price-input-group button:hover {
        background: #a00000;
    }
    .badge-status {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .badge-completed { background: rgba(46, 125, 50, 0.1); color: #2e7d32; }
    .badge-pending { background: rgba(245, 124, 0, 0.1); color: #f57c00; }
    .badge-failed { background: rgba(211, 47, 47, 0.1); color: #d32f2f; }
    .badge-rejected { background: rgba(211, 47, 47, 0.15); color: #c62828; }
    .badge-premium { background: rgba(212, 175, 55, 0.1); color: #b78a05; border: 1px solid rgba(212, 175, 55, 0.2); }
    .badge-standard { background: #f5f5f5; color: #777; }

    .action-btn-sm {
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 700;
        cursor: pointer;
        transition: 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-family: inherit;
    }
    .btn-approve { background: #e8f5e9; color: #2e7d32; }
    .btn-approve:hover { background: #2e7d32; color: white; }
    .btn-reject { background: #ffebee; color: #c62828; }
    .btn-reject:hover { background: #c62828; color: white; }

    .users-list-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }
    @media (max-width: 1024px) {
        .users-list-grid {
            grid-template-columns: 1fr;
        }
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 1.1rem 1rem;
        text-align: left;
        border-bottom: 1px solid #f2f2f2;
    }
    th {
        color: #888;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    td {
        font-weight: 500;
    }
</style>
@endsection

@section('content')
    <div style="margin-bottom: 3rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem;">
        <div>
            <h1 style="font-size: 2.5rem; color: #333; margin: 0 0 0.5rem;">Membership & Payments</h1>
            <p style="color: #888; font-size: 1.1rem; margin: 0;">Configure subscription models, view logs, and grant manual membership status overrides.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="admin-card" style="background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; padding: 1rem 2rem; margin-bottom: 2rem;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="admin-card" style="background: #ffebee; color: #c62828; border: 1px solid #ffcdd2; padding: 1rem 2rem; margin-bottom: 2rem;">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    <div class="tabs-nav">
        <button class="tab-btn active" onclick="switchTab(event, 'plans-pricing-tab')"><i class="fas fa-tags"></i> Plans & Pricing</button>
        <button class="tab-btn" onclick="switchTab(event, 'payment-history-tab')"><i class="fas fa-history"></i> Payment History</button>
        <button class="tab-btn" onclick="switchTab(event, 'directory-tab')"><i class="fas fa-user-shield"></i> Member Status Overrides</button>
    </div>

    <!-- TAB 1: Plans & Pricing -->
    <div id="plans-pricing-tab" class="tab-content active">
        <div class="plans-admin-grid">
            <!-- Free Plan -->
            <div class="plan-admin-card free-border">
                <div>
                    <h3 style="color: #333; font-size: 1.4rem; margin: 0 0 0.5rem;">Free Plan</h3>
                    <p style="color: #666; font-size: 0.9rem; margin-bottom: 1.5rem;">Default basic registration plan. Permits browsing and creating a profile.</p>
                    <div style="font-size: 2rem; font-weight: 800; color: #555;">₹0 <span style="font-size: 0.9rem; font-weight: 400; color: #999;">/ Lifetime</span></div>
                </div>
                <div style="margin-top: 2rem; border-top: 1px solid #f0f0f0; padding-top: 1.5rem;">
                    <span style="color: #2e7d32; font-weight: 700; font-size: 0.9rem;"><i class="fas fa-check-circle"></i> Default Plan (Always Enabled)</span>
                </div>
            </div>

            <!-- Gold Plan -->
            <div class="plan-admin-card gold-border">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h3 style="color: #800000; font-size: 1.4rem; margin: 0 0 0.5rem;">Gold Plan</h3>
                        <span style="color: #D4AF37; font-weight: 700; font-size: 0.8rem; background: rgba(212,175,55,0.1); padding: 4px 10px; border-radius: 12px;">PREMIUM</span>
                    </div>
                    <p style="color: #666; font-size: 0.9rem; margin-bottom: 1.5rem;">Unlocks view contact, direct messaging, profile boosting, and blue verification badges.</p>
                    <div style="font-size: 2rem; font-weight: 800; color: #800000;">
                        ₹{{ number_format(\App\Models\Setting::get('gold_plan_price', 1000)) }} 
                        <span style="font-size: 0.9rem; font-weight: 400; color: #999;">/ Lifetime</span>
                    </div>
                </div>

                <div style="margin-top: 2rem; border-top: 1px solid #f0f0f0; padding-top: 1.5rem;">
                    <label style="font-weight: 700; color: #333; font-size: 0.9rem;">Change Gold Plan Price (INR)</label>
                    <form action="{{ route('admin.memberships.plan.update') }}" method="POST">
                        @csrf
                        <div class="price-input-group">
                            <input type="number" name="gold_plan_price" value="{{ \App\Models\Setting::get('gold_plan_price', 1000) }}" min="0" required>
                            <button type="submit">Update Price</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 2: Payment History -->
    <div id="payment-history-tab" class="tab-content">
        <div class="admin-card">
            <h3 style="margin: 0 0 1.5rem; font-size: 1.3rem;"><i class="fas fa-list-alt"></i> Recent Transactions</h3>
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Plan</th>
                            <th>Amount</th>
                            <th>Order ID</th>
                            <th>Payment ID</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td>
                                    <div style="font-weight: 700; color: #333;">{{ $payment->user->name }}</div>
                                    <div style="font-size: 0.8rem; color: #888;">{{ $payment->user->email }}</div>
                                </td>
                                <td><span style="font-weight: 600;">{{ $payment->plan_name }}</span></td>
                                <td><span style="font-weight: 700; color: #800000;">₹{{ number_format($payment->amount) }}</span></td>
                                <td><code style="font-size: 0.85rem; color: #555;">{{ $payment->razorpay_order_id ?: 'MANUAL' }}</code></td>
                                <td><code style="font-size: 0.85rem; color: #555;">{{ $payment->razorpay_payment_id ?: 'N/A' }}</code></td>
                                <td>
                                    @if($payment->status === 'completed')
                                        <span class="badge-status badge-completed"><i class="fas fa-check-circle"></i> Success</span>
                                    @elseif($payment->status === 'pending')
                                        <span class="badge-status badge-pending"><i class="fas fa-clock"></i> Pending</span>
                                    @elseif($payment->status === 'failed')
                                        <span class="badge-status badge-failed"><i class="fas fa-times-circle"></i> Failed</span>
                                    @elseif($payment->status === 'approved')
                                        <span class="badge-status badge-completed"><i class="fas fa-user-check"></i> Approved</span>
                                    @elseif($payment->status === 'rejected')
                                        <span class="badge-status badge-rejected"><i class="fas fa-ban"></i> Rejected</span>
                                    @endif
                                </td>
                                <td style="color: #666; font-size: 0.9rem;">{{ $payment->created_at->format('M d, Y H:i') }}</td>
                                <td>
                                    <div style="display: flex; gap: 8px;">
                                        @if($payment->status !== 'completed' && $payment->status !== 'approved')
                                            <form action="{{ route('admin.memberships.payment.approve', $payment->id) }}" method="POST" onsubmit="return confirm('Manually approve this payment?')">
                                                @csrf
                                                <button type="submit" class="action-btn-sm btn-approve"><i class="fas fa-check"></i> Approve</button>
                                            </form>
                                        @endif
                                        @if($payment->status !== 'rejected' && $payment->status !== 'failed')
                                            <form action="{{ route('admin.memberships.payment.reject', $payment->id) }}" method="POST" onsubmit="return confirm('Reject and revoke membership for this payment?')">
                                                @csrf
                                                <button type="submit" class="action-btn-sm btn-reject"><i class="fas fa-times"></i> Reject</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align: center; color: #888; padding: 3rem;">No payment transactions recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- TAB 3: Member Directory / Overrides -->
    <div id="directory-tab" class="tab-content">
        <div class="users-list-grid">
            
            <!-- Standard Members List -->
            <div class="admin-card">
                <h3 style="margin: 0 0 1.5rem; font-size: 1.2rem; color: #555;"><i class="fas fa-user"></i> Standard Members (Grant Premium)</h3>
                <div style="overflow-y: auto; max-height: 500px;">
                    <table>
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>City / Occ</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($standardUsers as $user)
                                <tr>
                                    <td>
                                        <div style="font-weight: 700;">{{ $user->name }}</div>
                                        <div style="font-size: 0.8rem; color: #888;">{{ $user->email }}</div>
                                    </td>
                                    <td style="font-size: 0.85rem; color: #666;">
                                        {{ $user->profile->city ?? 'N/A' }}<br>
                                        {{ $user->profile->occupation ?? 'N/A' }}
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.memberships.user.approve', $user->id) }}" method="POST" onsubmit="return confirm('Manually grant Premium membership status to {{ $user->name }}?')">
                                            @csrf
                                            <button type="submit" class="action-btn-sm btn-approve"><i class="fas fa-crown"></i> Make Premium</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" style="text-align: center; color: #888; padding: 2rem;">No standard members found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Premium Members List -->
            <div class="admin-card">
                <h3 style="margin: 0 0 1.5rem; font-size: 1.2rem; color: #D4AF37;"><i class="fas fa-crown"></i> Active Premium Members (Revoke)</h3>
                <div style="overflow-y: auto; max-height: 500px;">
                    <table>
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>City / Occ</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($premiumUsers as $user)
                                <tr>
                                    <td>
                                        <div style="font-weight: 700; display: flex; align-items: center; gap: 6px;">
                                            {{ $user->name }}
                                            <span class="badge-status badge-premium" style="padding: 2px 6px; font-size: 0.65rem;"><i class="fas fa-check"></i> GOLD</span>
                                        </div>
                                        <div style="font-size: 0.8rem; color: #888;">{{ $user->email }}</div>
                                    </td>
                                    <td style="font-size: 0.85rem; color: #666;">
                                        {{ $user->profile->city ?? 'N/A' }}<br>
                                        {{ $user->profile->occupation ?? 'N/A' }}
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.memberships.user.reject', $user->id) }}" method="POST" onsubmit="return confirm('Revoke Premium membership status for {{ $user->name }}?')">
                                            @csrf
                                            <button type="submit" class="action-btn-sm btn-reject"><i class="fas fa-ban"></i> Revoke Premium</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" style="text-align: center; color: #888; padding: 2rem;">No active premium members.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
<script>
    function switchTab(evt, tabId) {
        // Hide all tab content
        const tabContents = document.querySelectorAll(".tab-content");
        tabContents.forEach(content => {
            content.classList.remove("active");
        });

        // Remove active class from all tab buttons
        const tabBtns = document.querySelectorAll(".tab-btn");
        tabBtns.forEach(btn => {
            btn.classList.remove("active");
        });

        // Show matching tab content
        document.getElementById(tabId).classList.add("active");
        evt.currentTarget.classList.add("active");
    }
</script>
@endsection
