@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }
    .stat-box {
        background: white;
        padding: 2.5rem;
        border-radius: 20px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: 0.3s;
        border: 1px solid rgba(0,0,0,0.02);
    }
    .stat-box:hover { transform: translateY(-5px); box-shadow: 0 15px 40px rgba(0,0,0,0.08); }
    .stat-box i { font-size: 2.5rem; color: #800000; margin-bottom: 1.5rem; }
    .stat-box h3 { font-size: 3rem; color: #333; margin: 0 0 0.5rem; font-weight: 800; }
    .stat-box p { color: #888; font-weight: 700; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px; }
    
    .recent-table-card { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
    th, td { padding: 1.2rem 1rem; text-align: left; border-bottom: 1px solid #f0f0f0; }
    th { color: #888; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px; font-weight: 700; }
    td { font-weight: 500; color: #444; }

    @media (max-width: 768px) {
        .stat-box { padding: 1.5rem; }
        .stat-box h3 { font-size: 2rem; }
    }
</style>
@endsection

@section('content')
    <div style="margin-bottom: 3rem;">
        <h1 style="font-size: 2.5rem; color: #333; margin-bottom: 0.5rem;">Welcome, Admin</h1>
        <p style="color: #888; font-size: 1.1rem;">Site overview and analytics</p>
    </div>

    <div class="stats-grid">
        <div class="stat-box">
            <i class="fas fa-users"></i>
            <h3>{{ $totalUsers }}</h3>
            <p>Total Users</p>
        </div>
        <div class="stat-box" style="border-bottom: 5px solid #D4AF37;">
            <i class="fas fa-crown" style="color: #D4AF37;"></i>
            <h3>{{ $premiumUsers }}</h3>
            <p>Premium Members</p>
        </div>
        <div class="stat-box">
            <i class="fas fa-heart"></i>
            <h3>{{ $totalInterests }}</h3>
            <p>Total Connections</p>
        </div>
    </div>

    <div class="admin-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h3 style="margin: 0; font-size: 1.5rem;">Recent User Registrations</h3>
            <a href="{{ route('admin.users') }}" style="color: #800000; font-weight: 700; text-decoration: none; font-size: 0.9rem;">View All Users <i class="fas fa-arrow-right"></i></a>
        </div>
        
        <div class="recent-table-card">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Joined Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentUsers as $user)
                        <tr>
                            <td style="font-weight: 700;">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td style="color: #888;">{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                @if($user->is_premium)
                                    <span style="color: #D4AF37; font-weight: 800; font-size: 0.8rem; background: rgba(212, 175, 55, 0.1); padding: 5px 12px; border-radius: 20px;">
                                        <i class="fas fa-crown"></i> PREMIUM
                                    </span>
                                @else
                                    <span style="color: #888; font-weight: 700; font-size: 0.8rem; background: #f5f5f5; padding: 5px 12px; border-radius: 20px;">
                                        STANDARD
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
