@extends('layouts.app')

@section('title', 'Profile Visitors | Kasar Samaj Matrimony')

@section('header_class', 'scrolled')

@section('styles')
    <style>
        body { 
            background-color: #fdfaf5; 
            background-image: radial-gradient(circle at 0% 0%, rgba(128, 0, 0, 0.03) 0%, transparent 50%),
                              radial-gradient(circle at 100% 100%, rgba(212, 175, 55, 0.05) 0%, transparent 50%);
            background-attachment: fixed;
        }
        .visitors-container { 
            padding: 8rem 5% 4rem; 
            min-height: 100vh; 
            max-width: 1300px; 
            margin: 0 auto; 
        }
        .visitors-header { text-align: center; margin-bottom: 5rem; position: relative; z-index: 10; }
        .visitors-header h1 { 
            color: var(--primary); 
            font-family: 'Playfair Display', serif; 
            font-size: 3.5rem; 
            margin-bottom: 1.5rem; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: 20px; 
            text-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .visitors-header p { color: #666; font-size: 1.2rem; max-width: 700px; margin: 0 auto; line-height: 1.7; opacity: 0.8; }
        
        .visitors-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); 
            gap: 2.5rem; 
            position: relative;
            z-index: 5;
        }
        
        .visitor-card { 
            background: white; 
            border-radius: 32px; 
            padding: 1.8rem; 
            display: flex; 
            align-items: center; 
            box-shadow: 0 10px 40px rgba(0,0,0,0.03); 
            border: 1px solid rgba(0,0,0,0.04); 
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); 
            text-decoration: none; 
            color: inherit; 
            position: relative; 
            overflow: hidden; 
        }
        .visitor-card:hover { transform: translateY(-12px) scale(1.02); box-shadow: 0 20px 60px rgba(128, 0, 0, 0.08); border-color: rgba(128, 0, 0, 0.1); }
        
        .user-photo { 
            width: 110px; 
            height: 110px; 
            border-radius: 28px; 
            background-size: cover; 
            background-position: center 20%; 
            margin-right: 1.8rem; 
            flex-shrink: 0; 
            border: 4px solid #fff; 
            box-shadow: 0 12px 25px rgba(0,0,0,0.12); 
            transition: 0.4s;
        }
        .user-info { flex-grow: 1; }
        .user-info h3 { 
            font-family: 'Playfair Display', serif; 
            color: var(--primary); 
            font-size: 1.8rem; 
            margin-bottom: 0.4rem; 
            font-weight: 800;
        }
        .user-info p { 
            color: #555; 
            font-size: 1rem; 
            margin-bottom: 0.8rem; 
            display: flex; 
            align-items: center; 
            gap: 8px; 
            font-weight: 500;
        }
        .time-badge { 
            display: inline-flex; 
            align-items: center; 
            gap: 6px; 
            font-size: 0.85rem; 
            color: var(--primary); 
            background: #fff0f0; 
            padding: 6px 16px; 
            border-radius: 50px; 
            font-weight: 700; 
            box-shadow: 0 2px 8px rgba(128,0,0,0.05);
        }

        /* Curiosity Hook: Blurred State */
        .visitor-card.blurred .user-photo { filter: blur(15px); transform: scale(1.15); opacity: 0.7; }
        .visitor-card.blurred .user-info h3 { filter: blur(7px); user-select: none; opacity: 0.5; }
        .visitor-card.blurred .user-info p { filter: blur(5px); user-select: none; opacity: 0.4; }
        
        .premium-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(3px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            opacity: 0;
            transition: 0.4s;
        }
        .visitor-card.blurred:hover .premium-overlay { opacity: 1; }
        .unlock-btn { 
            background: var(--primary-gradient); 
            color: white; 
            padding: 12px 24px; 
            border-radius: 50px; 
            font-weight: 800; 
            font-size: 0.85rem; 
            box-shadow: 0 10px 25px rgba(128, 0, 0, 0.4);
            transform: translateY(20px);
            transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .visitor-card.blurred:hover .unlock-btn { transform: translateY(0); }

        .empty-state { 
            grid-column: 1 / -1; 
            text-align: center; 
            padding: 8rem 4rem; 
            background: rgba(255, 255, 255, 0.6); 
            backdrop-filter: blur(20px);
            border-radius: 40px; 
            box-shadow: 0 20px 60px rgba(0,0,0,0.05); 
            border: 1px solid rgba(255,255,255,0.4);
            max-width: 800px;
            margin: 0 auto;
        }
        .empty-state i { 
            font-size: 6rem; 
            background: linear-gradient(135deg, #eee 0%, #ccc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 2rem; 
            display: block; 
        }
        
        .counter-badge { 
            background: var(--primary-gradient); 
            color: white; 
            padding: 8px 24px; 
            border-radius: 50px; 
            font-size: 1.1rem; 
            font-weight: 800; 
            margin-bottom: 1.5rem; 
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 25px rgba(128,0,0,0.25); 
            border: 2px solid rgba(255,255,255,0.2);
        }
    </style>
@endsection

@section('content')
    <div class="visitors-container">
        <div class="visitors-header">
            <div class="counter-badge">
                <i class="fas fa-bolt"></i> {{ $visitors->count() }} Profiles Viewed You Recently
            </div>
            <h1><i class="fas fa-eye"></i> Who Viewed You?</h1>
            <p>Your profile is getting attention! See who has been looking at you and find your perfect life partner faster.</p>
        </div>

        <div class="visitors-grid">
            @php $isPremium = Auth::user()->is_premium; @endphp
            @forelse($visitors as $view)
                @php $v = $view->viewer; @endphp
                <a href="{{ $isPremium ? route('home') . '?search_user=' . $v->id : route('plans') }}" class="visitor-card {{ $isPremium ? '' : 'blurred' }}">
                    @if(!$isPremium)
                        <div class="premium-overlay">
                            <div class="unlock-btn"><i class="fas fa-lock"></i> Unlock to See</div>
                        </div>
                    @endif
                    
                    <div class="user-photo" style="background-image: url('{{ $v->profile->photo1 ? asset('storage/'.$v->profile->photo1) : 'https://ui-avatars.com/api/?name='.urlencode($v->name) }}');"></div>
                    <div class="user-info">
                        <h3>{{ $isPremium ? $v->name : 'Secret Visitor' }}</h3>
                        <p><i class="fas fa-briefcase"></i> {{ $isPremium ? ($v->profile->occupation ?: 'Professional') : 'Hidden Occupation' }}</p>
                        <p><i class="fas fa-map-marker-alt"></i> {{ $isPremium ? ($v->profile->city ?: 'Location hidden') : 'Hidden City' }}</p>
                        <div class="time-badge">
                            <i class="far fa-clock"></i> {{ $view->created_at->diffForHumans() }}
                        </div>
                    </div>
                </a>
            @empty
                <div class="empty-state">
                    <i class="fas fa-user-secret"></i>
                    <h2>No Visitors Yet</h2>
                    <p style="color: #888;">Complete your profile and add photos to attract more people!</p>
                    <a href="{{ route('profile.edit') }}" class="btn-primary" style="display: inline-flex; text-decoration: none; margin-top: 2rem; border-radius: 50px;">Update Profile</a>
                </div>
            @endforelse
        </div>

        @if(!$isPremium && $visitors->count() > 0)
            <div style="text-align: center; margin-top: 5rem; padding: 4rem; background: white; border-radius: 30px; border: 2px solid var(--secondary); box-shadow: 0 20px 50px rgba(212, 175, 55, 0.1);">
                <i class="fas fa-crown" style="font-size: 3rem; color: var(--secondary); margin-bottom: 1.5rem;"></i>
                <h2 style="font-family: 'Playfair Display', serif; color: var(--primary); font-size: 2.2rem; margin-bottom: 1rem;">Don't Stay in the Dark!</h2>
                <p style="color: #666; font-size: 1.1rem; max-width: 600px; margin: 0 auto 2.5rem;">Upgrade to **Premium** now to see exactly who is looking at your profile and start a conversation with them.</p>
                <a href="{{ route('plans') }}" class="btn-premium" style="padding: 1.2rem 3.5rem; font-size: 1.2rem;">Upgrade to Premium Now</a>
            </div>
        @endif
    </div>
@endsection
