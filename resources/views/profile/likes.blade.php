@extends('layouts.app')

@section('title', 'People Who Liked You | Kasar Samaj Matrimony')

@section('header_class', 'scrolled')

@section('styles')
    <style>
        body { background-color: #fdfaf5; }
        .likes-container { padding: 4rem 5%; min-height: 80vh; max-width: 1200px; margin: 0 auto; }
        .likes-header { text-align: center; margin-bottom: 4rem; }
        .likes-header h1 { color: var(--primary); font-family: 'Playfair Display', serif; font-size: 3rem; margin-bottom: 1rem; display: flex; align-items: center; justify-content: center; gap: 15px; }
        .likes-header p { color: #666; font-size: 1.1rem; max-width: 600px; margin: 0 auto; }
        .likes-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2rem; }
        .like-card { background: white; border-radius: 24px; padding: 1.5rem; display: flex; align-items: center; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.02); transition: var(--transition); text-decoration: none; color: inherit; }
        .like-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-md); border-color: rgba(128, 0, 0, 0.1); }
        .user-photo { 
            width: 100px; 
            height: 100px; 
            border-radius: 24px; 
            background-size: cover; 
            background-position: center 20%; 
            margin-right: 1.5rem; 
            flex-shrink: 0; 
            border: 3px solid #fff; 
            box-shadow: 0 8px 20px rgba(0,0,0,0.1); 
        }
        .user-info { flex-grow: 1; }
        .user-info h3 { 
            font-family: 'Playfair Display', serif; 
            color: var(--primary); 
            font-size: 1.7rem; 
            margin-bottom: 0.3rem; 
            font-weight: 800;
        }
        .user-info p { 
            color: #444; 
            font-size: 0.95rem; 
            margin-bottom: 0.6rem; 
            display: flex; 
            align-items: center; 
            gap: 6px; 
            font-weight: 500;
        }
        .time-badge { 
            display: inline-flex; 
            align-items: center; 
            gap: 5px; 
            font-size: 0.8rem; 
            color: var(--primary); 
            background: #fff5f5; 
            padding: 5px 14px; 
            border-radius: 50px; 
            font-weight: 700; 
        }
        .empty-state { grid-column: 1 / -1; text-align: center; padding: 6rem 2rem; background: white; border-radius: 32px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); }
        .empty-state i { font-size: 4rem; color: #eee; margin-bottom: 1.5rem; display: block; }
        .premium-tag { background: var(--secondary-gradient); color: #5c4300; padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; margin-bottom: 1rem; display: inline-block; }
    </style>
@endsection

@section('content')
    <div class="likes-container">
        <div class="likes-header">
            <div class="premium-tag"><i class="fas fa-crown"></i> Premium Feature</div>
            <h1><i class="fas fa-heart" style="color: #e74c3c;"></i> People Who Liked You</h1>
            <p>Discover who has shown interest in your profile. These are people who matched your search but specifically liked your photos!</p>
        </div>

        <div class="likes-grid">
            @forelse($likedBy as $like)
                @php $u = $like->user; @endphp
                <a href="{{ route('home') }}?search_user={{ $u->id }}" class="like-card">
                    <div class="user-photo" style="background-image: url('{{ $u->profile->photo1 ? asset('storage/'.$u->profile->photo1) : 'https://ui-avatars.com/api/?name='.urlencode($u->name) }}');"></div>
                    <div class="user-info">
                        <h3>
                            {{ $u->name }}
                            @if($u->profile->is_verified)
                                <span class="verified-badge {{ $u->is_premium ? 'gold' : '' }}" title="Verified Profile">
                                    <i class="fas fa-check"></i>
                                </span>
                            @endif
                        </h3>
                        <p><i class="fas fa-briefcase"></i> {{ $u->profile->occupation ?: 'Professional' }}</p>
                        <p><i class="fas fa-map-marker-alt"></i> {{ $u->profile->city ?: 'Location unknown' }}</p>
                        <div class="time-badge">
                            <i class="far fa-clock"></i> {{ $like->created_at->diffForHumans() }}
                        </div>
                    </div>
                </a>
            @empty
                <div class="empty-state">
                    <i class="fas fa-heart-circle-xmark"></i>
                    <h2>No Likes Yet</h2>
                    <p style="color: #888;">Try adding more photos or updating your bio to get noticed!</p>
                    <a href="{{ route('profile.edit') }}" class="btn-primary" style="display: inline-flex; text-decoration: none; margin-top: 2rem; border-radius: 50px;">Update Profile</a>
                </div>
            @endforelse
        </div>
    </div>
@endsection
