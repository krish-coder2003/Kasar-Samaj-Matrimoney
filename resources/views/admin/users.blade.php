@extends('layouts.admin')

@section('title', 'Manage Users')

@section('styles')
<style>
    .user-table-card { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
    th, td { padding: 1.2rem 1rem; text-align: left; border-bottom: 1px solid #f0f0f0; }
    th { color: #888; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px; font-weight: 700; }
    td { font-weight: 500; color: #444; }
    
    .btn-action { padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; font-size: 0.85rem; font-weight: 600; transition: 0.3s; display: inline-flex; align-items: center; gap: 5px; }
    .btn-edit { background: rgba(0, 123, 255, 0.1); color: #007bff; border: 1px solid rgba(0, 123, 255, 0.2); }
    .btn-edit:hover { background: #007bff; color: white; }
    .btn-delete { background: rgba(220, 53, 69, 0.1); color: #dc3545; border: 1px solid rgba(220, 53, 69, 0.2); }
    .btn-delete:hover { background: #dc3545; color: white; }
    
    .badge { padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; }
    .badge-premium { background: rgba(212, 175, 55, 0.1); color: #D4AF37; border: 1px solid rgba(212, 175, 55, 0.2); }
    .badge-standard { background: #f5f5f5; color: #888; border: 1px solid #eee; }
</style>
@endsection

@section('content')
    <div style="margin-bottom: 3rem;">
        <h1 style="font-size: 2.5rem; color: #333; margin-bottom: 0.5rem;">Manage Users</h1>
        <p style="color: #888; font-size: 1.1rem;">Manage user accounts, roles and membership status</p>
    </div>

    @if(session('success'))
        <div class="admin-card" style="background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; padding: 1rem 2rem; margin-bottom: 2rem;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="admin-card">
        <div class="desktop-only">
            <div class="user-table-card">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Location</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td style="font-weight: 700;">{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span style="background: rgba(0,0,0,0.05); padding: 4px 10px; border-radius: 5px; font-size: 0.7rem; font-weight: 800;">
                                        {{ strtoupper($user->role) }}
                                    </span>
                                </td>
                                <td>
                                    @if($user->is_premium)
                                        <span class="badge badge-premium"><i class="fas fa-crown"></i> PREMIUM</span>
                                    @else
                                        <span class="badge badge-standard">STANDARD</span>
                                    @endif
                                </td>
                                <td>{{ $user->profile->city ?? 'N/A' }}</td>
                                <td style="text-align: right;">
                                    @if($user->id !== auth()->id())
                                        <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                            <a href="{{ route('admin.users.edit', $user) }}" class="btn-action btn-edit"><i class="fas fa-edit"></i> Edit</a>
                                            <form action="{{ route('admin.users.delete', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn-action btn-delete" style="background: none; border: none; cursor: pointer;"><i class="fas fa-trash-alt"></i> Delete</button>
                                            </form>
                                        </div>
                                    @else
                                        <span style="color: #888; font-style: italic; font-size: 0.8rem;">Current Account</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mobile-only">
            @foreach($users as $user)
                <div style="padding: 1.5rem; border: 1px solid #eee; border-radius: 15px; margin-bottom: 1.5rem; background: #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                        <div>
                            <h3 style="margin: 0; color: #333; font-size: 1.2rem; font-weight: 700;">{{ $user->name }}</h3>
                            <p style="margin: 4px 0 0; color: #888; font-size: 0.9rem;">{{ $user->email }}</p>
                        </div>
                        @if($user->is_premium)
                            <span class="badge badge-premium"><i class="fas fa-crown"></i> Premium</span>
                        @endif
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 1.5rem; font-size: 0.85rem;">
                        <div><strong style="color: #888;">Role:</strong> <span style="font-weight: 700; color: #444;">{{ strtoupper($user->role) }}</span></div>
                        <div><strong style="color: #888;">City:</strong> <span style="font-weight: 700; color: #444;">{{ $user->profile->city ?? 'N/A' }}</span></div>
                    </div>

                    @if($user->id !== auth()->id())
                        <div style="display: flex; gap: 10px;">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn-action btn-edit" style="flex: 1; justify-content: center; padding: 0.8rem;"><i class="fas fa-edit"></i> Edit</a>
                            <form action="{{ route('admin.users.delete', $user) }}" method="POST" onsubmit="return confirm('Are you sure?')" style="flex: 1;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" style="width: 100%; justify-content: center; padding: 0.8rem; background: none; border: none; cursor: pointer;"><i class="fas fa-trash-alt"></i> Delete</button>
                            </form>
                        </div>
                    @else
                        <div style="text-align: center; color: #888; font-style: italic; font-size: 0.9rem; padding: 0.8rem; background: #f9f9f9; border-radius: 10px;">Your Account</div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection
