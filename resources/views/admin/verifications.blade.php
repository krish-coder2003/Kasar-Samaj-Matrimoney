@extends('layouts.admin')

@section('title', 'Identity Verifications')

@section('styles')
<style>
    .verif-table-card { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 1.5rem 1rem; text-align: left; border-bottom: 1px solid #f0f0f0; }
    th { color: #888; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; font-weight: 700; }
    
    .aadhaar-thumbnail {
        width: 140px;
        height: 90px;
        border-radius: 12px;
        background-size: cover;
        background-position: center;
        border: 2px solid #eee;
        cursor: pointer;
        transition: 0.3s;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    .aadhaar-thumbnail:hover { transform: scale(1.05); border-color: #800000; box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
    
    .status-badge { padding: 6px 14px; border-radius: 20px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; }
    .status-pending { background: #fff8e1; color: #f57f17; border: 1px solid rgba(245, 127, 23, 0.2); }
    .status-approved { background: #e8f5e9; color: #2e7d32; border: 1px solid rgba(46, 125, 50, 0.2); }
    .status-rejected { background: #ffebee; color: #c62828; border: 1px solid rgba(198, 40, 40, 0.2); }
    
    .btn-verif { padding: 8px 18px; border-radius: 8px; font-weight: 700; font-size: 0.85rem; border: none; cursor: pointer; transition: 0.3s; }
    .btn-approve { background: #2e7d32; color: white; }
    .btn-approve:hover { background: #1b5e20; transform: translateY(-2px); }
    .btn-reject { background: #c62828; color: white; }
    .btn-reject:hover { background: #b71c1c; transform: translateY(-2px); }
    
    .img-modal {
        display: none;
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.95);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        padding: 2rem;
        backdrop-filter: blur(5px);
    }
    .img-modal img { max-width: 90%; max-height: 90%; border-radius: 20px; box-shadow: 0 0 50px rgba(0,0,0,0.5); border: 4px solid white; }
    .close-modal { position: absolute; top: 30px; right: 30px; color: white; font-size: 2.5rem; cursor: pointer; transition: 0.3s; }
    .close-modal:hover { color: #ff7675; transform: rotate(90deg); }
</style>
@endsection

@section('content')
    <div style="margin-bottom: 3rem;">
        <h1 style="font-size: 2.5rem; color: #333; margin-bottom: 0.5rem;">Profile Verifications</h1>
        <p style="color: #888; font-size: 1.1rem;">Review identity documents and verify user profiles</p>
    </div>

    @if(session('success'))
        <div class="admin-card" style="background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; padding: 1rem 2rem; margin-bottom: 2rem;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="admin-card" style="padding: 1rem;">
        <div class="verif-table-card">
            <table>
                <thead>
                    <tr>
                        <th>User Information</th>
                        <th>Aadhaar Card Document</th>
                        <th>Current Status</th>
                        <th style="text-align: right;">Decision Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($profiles as $profile)
                        <tr>
                            <td>
                                <div style="font-weight: 800; color: #333; font-size: 1.1rem;">{{ $profile->user->name }}</div>
                                <div style="color: #888; font-size: 0.9rem; margin-bottom: 8px;">{{ $profile->user->email }}</div>
                                @if($profile->user->is_premium)
                                    <span style="color: #D4AF37; font-size: 0.75rem; font-weight: 800; background: rgba(212, 175, 55, 0.1); padding: 3px 10px; border-radius: 20px;"><i class="fas fa-crown"></i> PREMIUM</span>
                                @endif
                            </td>
                            <td>
                                <div class="aadhaar-thumbnail" 
                                     style="background-image: url('{{ asset('storage/' . $profile->aadhaar_card) }}');"
                                     onclick="showFullImage('{{ asset('storage/' . $profile->aadhaar_card) }}')">
                                    <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:rgba(0,0,0,0.2); opacity:0; transition:0.3s; border-radius:12px;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0">
                                        <i class="fas fa-search-plus" style="color:white; font-size:1.5rem;"></i>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $profile->verification_status }}">
                                    {{ $profile->verification_status }}
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <div style="display: flex; gap: 10px; justify-content: flex-end;">
                                    @if($profile->verification_status != 'approved')
                                        <form action="{{ route('admin.verifications.approve', $profile) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-verif btn-approve"><i class="fas fa-check"></i> Approve</button>
                                        </form>
                                    @endif
                                    
                                    @if($profile->verification_status != 'rejected')
                                        <form action="{{ route('admin.verifications.reject', $profile) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-verif btn-reject"><i class="fas fa-times"></i> Reject</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 5rem; color: #888;">
                                <i class="fas fa-id-card" style="font-size: 4rem; margin-bottom: 1.5rem; display: block; opacity: 0.1; color: #800000;"></i>
                                <span style="font-size: 1.2rem; font-weight: 500;">No pending verification requests.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="imgModal" class="img-modal">
        <span class="close-modal" onclick="closeModal()">&times;</span>
        <img id="fullImage" src="">
    </div>
@endsection

@section('scripts')
<script>
    function showFullImage(src) {
        const modal = document.getElementById('imgModal');
        const img = document.getElementById('fullImage');
        img.src = src;
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden'; // Disable scroll
    }
    function closeModal() {
        document.getElementById('imgModal').style.display = 'none';
        document.body.style.overflow = 'auto'; // Enable scroll
    }
    
    // Close modal on click outside image
    document.getElementById('imgModal').addEventListener('click', function(e) {
        if(e.target === this) closeModal();
    });
</script>
@endsection
