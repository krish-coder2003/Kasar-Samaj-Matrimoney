<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasar Samaj Matrimony | Premium Matchmaking</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #800000 0%, #a00000 100%);
            --secondary-gradient: linear-gradient(135deg, #D4AF37 0%, #F1D479 100%);
            --shadow-md: 0 10px 30px rgba(0,0,0,0.08);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Modern Profile Detail Modal Overrides */
        .detail-modal {
            padding: 2rem;
            background: rgba(0,0,0,0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .detail-content {
            background: #fff;
            border-radius: 32px;
            padding: 0;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.1);
            max-width: 1100px;
            box-shadow: 0 40px 100px rgba(0,0,0,0.5);
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 450px 1fr;
            gap: 0;
        }



        .detail-photos {
            background: #f8f9fa;
            position: relative;
        }

        .detail-main-photo {
            height: 600px !important;
            background-size: contain !important;
            background-repeat: no-repeat !important;
            background-position: center !important;
            background-color: #0a0a0a !important; /* Premium dark background for no-crop view */
            border-radius: 0 !important;
            transition: var(--transition);
        }

        .detail-thumbs-container {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            background: rgba(255,255,255,0.3);
            padding: 10px;
            border-radius: 20px;
            backdrop-filter: blur(10px);
        }

        .detail-thumb {
            width: 60px !important;
            height: 60px !important;
            border-radius: 12px !important;
            border: 2px solid white !important;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .detail-info {
            padding: 3rem !important;
            height: 600px;
            overflow-y: auto;
            background: white;
        }

        .detail-info::-webkit-scrollbar { width: 6px; }
        .detail-info::-webkit-scrollbar-thumb { background: #eee; border-radius: 10px; }

        .detail-header {
            margin-bottom: 2.5rem;
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 1.5rem;
        }

        .detail-header h2 {
            font-size: 2.8rem !important;
            margin-bottom: 0.5rem !important;
            color: #1a1a1a !important;
        }

        .detail-section {
            margin-bottom: 3rem;
        }

        .detail-section h3 {
            font-size: 1.2rem;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .detail-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .info-pill {
            background: #fcfcfc;
            padding: 1rem 1.5rem;
            border-radius: 16px;
            border: 1px solid #f0f0f0;
            transition: var(--transition);
        }

        .info-pill:hover {
            border-color: var(--primary);
            background: #fffafa;
            transform: translateY(-2px);
        }

        .info-pill label {
            display: block;
            font-size: 0.75rem;
            color: #999;
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .info-pill span {
            font-size: 1.05rem;
            color: #333;
            font-weight: 600;
        }

        .detail-tag {
            background: var(--primary-gradient) !important;
            color: white !important;
            border: none !important;
            padding: 8px 18px !important;
            font-size: 0.9rem !important;
            box-shadow: 0 4px 10px rgba(128, 0, 0, 0.15);
        }

        .btn-floating {
            position: sticky;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            padding: 1.5rem 0 0;
            border-top: 1px solid #f0f0f0;
            z-index: 100;
            margin-top: 2rem;
        }

        .close-modal-btn {
            position: absolute;
            top: 25px;
            right: 25px;
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            cursor: pointer;
            z-index: 100;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            transition: var(--transition);
            color: #333;
        }

        .close-modal-btn:hover {
            transform: rotate(90deg);
            background: var(--primary);
            color: white;
        }
        /* Premium Match Card Enhancements */
        .match-card {
            border-radius: 24px !important;
            border: 1px solid #f0f0f0 !important;
            transition: var(--transition) !important;
            background: white !important;
            position: relative;
        }

        .match-card:hover {
            transform: translateY(-10px) !important;
            box-shadow: 0 20px 40px rgba(128, 0, 0, 0.1) !important;
            border-color: rgba(128, 0, 0, 0.1) !important;
        }

        .match-photo {
            height: 300px !important;
            border-radius: 24px 24px 0 0 !important;
        }

        .match-info h4 {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem !important;
            margin-bottom: 0.8rem !important;
        }

        .match-details span {
            display: flex !important;
            align-items: center;
            gap: 8px;
            margin-bottom: 0.5rem !important;
            color: #777 !important;
        }

        .match-details i {
            color: var(--primary);
            font-size: 0.9rem;
            width: 16px;
        }

        .like-btn {
            background: white !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
            border: none !important;
        }

        /* Modern Search Bar Styles */
        .search-container {
            max-width: 500px;
            margin: 0 auto 4rem;
            background: white;
            padding: 12px;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.06);
            border: 1px solid rgba(0,0,0,0.03);
            transition: var(--transition);
        }

        @media (max-width: 768px) {
            .match-photo { height: 260px !important; }
            .match-info { padding: 1.2rem !important; }
            .match-info h4 { font-size: 1.15rem !important; margin-bottom: 0.4rem !important; }
            .match-details span { font-size: 0.8rem !important; margin-bottom: 0.3rem !important; }
            .match-card { border-radius: 16px !important; }
            .btn-view-profile { padding: 0.6rem 1.2rem !important; font-size: 0.85rem !important; }
            .like-btn { width: 35px !important; height: 35px !important; font-size: 0.9rem !important; }
            
            .search-container { padding: 8px 12px !important; margin-bottom: 2rem !important; border-radius: 15px !important; max-width: 95% !important; }
            .search-form { flex-direction: row !important; gap: 8px !important; }
            .search-input-group { flex: 1 !important; }
            .search-input-group input { padding: 0.6rem 0.8rem 0.6rem 2.2rem !important; font-size: 0.85rem !important; }
            .search-input-group i { left: 10px !important; font-size: 0.8rem !important; }
            .btn-premium { padding: 0.6rem 1.2rem !important; font-size: 0.85rem !important; width: auto !important; min-width: 80px !important; }
            .btn-clear-modern { padding: 0.6rem 1rem !important; font-size: 0.8rem !important; }
            .search-group { margin-bottom: 0.5rem; }
            .search-group label { font-size: 0.75rem !important; margin-bottom: 4px !important; }
            .search-group select, .search-group input { padding: 0.6rem 0.8rem !important; font-size: 0.85rem !important; }
            
            .detail-modal { padding: 10px !important; }
            .close-modal-btn { top: 15px; right: 15px; width: 40px; height: 40px; font-size: 1.2rem; }
        }

        .search-container:focus-within {
            box-shadow: 0 15px 50px rgba(128, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .search-form {
            display: flex;
            align-items: stretch;
            gap: 12px;
            width: 100%;
        }

        @media (max-width: 768px) {
            .search-container {
                margin: 0 auto 2rem;
            }
        }

        .search-input-group {
            position: relative;
            flex: 1;
        }

        .search-input-group i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            font-size: 1.1rem;
            opacity: 0.5;
            transition: var(--transition);
        }

        .search-input-group input {
            width: 100%;
            padding: 16px 20px 16px 55px;
            border: 2px solid #f8f9fa;
            border-radius: 18px;
            font-size: 1rem;
            font-family: 'Outfit', sans-serif;
            transition: var(--transition);
            background: #fcfcfc;
            color: #333;
        }

        .search-input-group input:focus {
            border-color: var(--primary);
            background: white;
            box-shadow: none;
            outline: none;
        }

        .search-input-group input:focus + i {
            opacity: 1;
        }

        .btn-premium {
            background-color: #800000;
            background: var(--primary-gradient);
            color: #fff !important;
            padding: 16px 35px;
            border-radius: 18px;
            border: none;
            cursor: pointer;
            font-weight: 700;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: var(--transition);
            box-shadow: 0 8px 20px rgba(128, 0, 0, 0.2);
            white-space: nowrap;
        }

        @media (max-width: 768px) {
            .btn-premium { padding: 16px; }
        }

        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(128, 0, 0, 0.3);
        }

        .btn-clear-modern {
            padding: 0 25px;
            border-radius: 18px;
            background: #f8f9fa;
            color: #888;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: 600;
            transition: var(--transition);
            border: 2px solid transparent;
        }

        @media (max-width: 768px) {
            .btn-clear-modern { padding: 16px; }
        }

        .btn-clear-modern:hover {
            background: #fffafa;
            color: var(--primary);
            border-color: #ffebeb;
        }

        /* Final Polished Mobile Modal */
        @media (max-width: 992px) {
            .detail-modal { 
                padding: 0 !important; 
                background: rgba(0,0,0,0.85) !important;
            }
            .detail-content { 
                width: 100% !important; 
                height: 100% !important; 
                max-width: 100% !important; 
                max-height: 100% !important; 
                margin: 0 !important; 
                border-radius: 0 !important;
                display: flex !important;
                flex-direction: column !important;
                background: #fff !important;
            }
            .detail-grid { 
                display: flex !important;
                flex-direction: column !important;
                height: 100% !important;
                overflow: hidden !important;
                gap: 0 !important;
            }
            .detail-photos { 
                height: 40vh !important; 
                min-height: 300px;
                flex-shrink: 0 !important;
                position: relative;
            }
            .detail-main-photo { 
                height: 100% !important; 
                border-radius: 0 !important; 
            }
            .detail-info { 
                flex: 1 !important;
                padding: 1.5rem 1.5rem 90px !important; 
                overflow-y: auto !important; 
                -webkit-overflow-scrolling: touch;
            }
            .detail-header {
                text-align: left !important;
                margin-bottom: 2rem !important;
            }
            .detail-header h2 { 
                font-size: 1.8rem !important; 
                line-height: 1.2 !important;
                display: flex;
                align-items: center;
                flex-wrap: wrap;
            }
            .detail-info-grid { 
                grid-template-columns: 1fr !important; 
                gap: 12px !important; 
            }
            .info-pill {
                padding: 12px 15px !important;
            }
            .btn-floating { 
                position: absolute !important; 
                bottom: 0 !important; 
                left: 0 !important; 
                right: 0 !important; 
                background: #fff !important; 
                padding: 15px 20px !important; 
                border-top: 1px solid #eee !important; 
                margin: 0 !important;
                z-index: 1000 !important;
                box-shadow: 0 -5px 20px rgba(0,0,0,0.1) !important;
                display: block !important;
            }
            #send-interest-btn {
                width: 100% !important;
                height: 54px !important;
                font-size: 1.1rem !important;
                border-radius: 12px !important;
                display: flex !important;
                align-items: center;
                justify-content: center;
                gap: 10px;
                margin: 0 !important;
            }
            .close-modal-btn { 
                top: 15px !important; 
                right: 15px !important; 
                width: 36px !important; 
                height: 36px !important; 
                font-size: 1.2rem !important; 
                background: rgba(0,0,0,0.4) !important; 
                color: white !important; 
                z-index: 1100 !important;
                display: flex !important;
                align-items: center;
                justify-content: center;
                border-radius: 50% !important;
                backdrop-filter: blur(4px);
            }
            .detail-thumbs-container { 
                bottom: 10px !important; 
                padding: 5px !important;
            }
            .detail-thumb { 
                width: 45px !important; 
                height: 45px !important; 
                border-width: 2px !important;
            }
        }
    </style>
</head>

<body>
    @include('partials.recovery-banner')

    @if(session('success'))
        <div class="notification success" style="display: block; z-index: 9999;">
            {{ session('success') }}
        </div>
    @endif

    @include('partials.header')

    @auth
    <!-- Matches Section for Logged-in Users -->
    <section class="matches-section" id="matches">
        <h2 class="section-title">Matches for You</h2>

        @php
            $featuredMatches = $matches->where('profile.is_featured', true)->take(3);
        @endphp

        @if($featuredMatches->count() > 0)
            <div class="spotlight-container">
                <h3 style="color: #D4AF37; margin-bottom: 2rem; display: flex; align-items: center; gap: 10px; font-family: 'Playfair Display', serif;">
                    <i class="fas fa-crown"></i> Elite Spotlight
                </h3>
                <div class="spotlight-grid">
                    @foreach($featuredMatches as $match)
                        <div class="match-card spotlight-card">
                            @php
                                $p = $match->profile;
                                $photos = array_filter([$p->photo1, $p->photo2, $p->photo3]);
                                $mainPhoto = !empty($photos) ? asset('storage/' . $photos[0]) : 'https://ui-avatars.com/api/?name=' . urlencode($match->name) . '&background=800000&color=fff&size=300';
                            @endphp
                            <div class="match-photo" style="background-image: url('{{ $mainPhoto }}');">
                                <div class="like-btn {{ in_array($match->id, $likedUserIds) ? 'active' : '' }}" onclick="toggleLike({{ $match->id }}, event)">
                                    <i class="{{ in_array($match->id, $likedUserIds) ? 'fas' : 'far' }} fa-heart"></i>
                                </div>
                            </div>
                            <div class="match-info">
                                <h4>
                                    {{ $match->name }}
                                    @if($p->is_verified)
                                        <span class="verified-badge {{ $match->is_premium ? 'gold' : '' }}" title="Verified Profile">
                                            <i class="fas fa-check"></i>
                                        </span>
                                    @endif
                                </h4>
                                <p style="font-size: 0.85rem; color: #D4AF37; font-weight: 700; margin-bottom: 0.5rem; letter-spacing: 1px;">PREMIUM SPOTLIGHT</p>
                                <button class="btn-premium btn-block" style="padding: 0.5rem; font-size: 0.85rem;" onclick="openDetailModal({{ json_encode($match) }}, {{ json_encode($photos) }}, {{ Auth::user()->is_premium ? 'true' : 'false' }}, {{ in_array($match->id, $sentInterestIds) ? 'true' : 'false' }})">View Elite Profile</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        
        <div class="search-container">
            <form action="{{ route('home') }}" method="GET" class="search-form">
                <div class="search-input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="name" placeholder="Search by Name..." value="{{ request('name') }}">
                </div>
                <button type="submit" class="btn-premium" style="padding: 0.7rem 1.5rem; font-size: 0.9rem; min-width: auto;">
                    <i class="fas fa-search"></i> Search
                </button>
                @if(request('name'))
                    <a href="{{ route('home') }}" class="btn-clear-modern" style="padding: 0.7rem 1.2rem; font-size: 0.85rem;">
                        <i class="fas fa-undo"></i> Clear
                    </a>
                @endif
            </form>
        </div>

        <div class="matches-grid">
            @forelse($matches as $match)
                <div class="match-card">
                    @php
                        $p = $match->profile;
                        $photos = array_filter([$p->photo1, $p->photo2, $p->photo3]);
                        $mainPhoto = !empty($photos) ? asset('storage/' . $photos[0]) : 'https://ui-avatars.com/api/?name=' . urlencode($match->name) . '&background=800000&color=fff&size=300';
                    @endphp
                    <div class="match-photo" id="main-photo-{{ $match->id }}" style="background-image: url('{{ $mainPhoto }}'); position: relative;">
                        <div class="like-btn {{ in_array($match->id, $likedUserIds) ? 'active' : '' }}" onclick="toggleLike({{ $match->id }}, event)" id="like-{{ $match->id }}">
                            <i class="{{ in_array($match->id, $likedUserIds) ? 'fas' : 'far' }} fa-heart"></i>
                        </div>
                    </div>
                    
                    @if(count($photos) > 1)
                        <div class="photo-thumbnails">
                            @foreach($photos as $photo)
                                <div class="thumb" style="background-image: url('{{ asset('storage/' . $photo) }}');" onclick="changePhoto({{ $match->id }}, '{{ asset('storage/' . $photo) }}')"></div>
                            @endforeach
                        </div>
                    @endif

                    <div class="match-info">
                        <h4>
                            {{ $match->name }}
                            @if($match->profile->is_verified)
                                <span class="verified-badge {{ $match->is_premium ? 'gold' : '' }}" title="Verified Profile">
                                    <i class="fas fa-check"></i>
                                </span>
                            @endif
                        </h4>
                        <div class="match-details">
                            <span><i class="fas fa-birthday-cake"></i> Age: {{ \Carbon\Carbon::parse($match->profile->dob)->age ?? 'N/A' }} yrs</span>
                            <span><i class="fas fa-graduation-cap"></i> Education: {{ $match->profile->education ?? 'N/A' }}</span>
                            <span><i class="fas fa-briefcase"></i> Occupation: {{ $match->profile->occupation ?? 'N/A' }}</span>
                            <span><i class="fas fa-map-marker-alt"></i> City: {{ $match->profile->city ?? 'N/A' }}, {{ $match->profile->state ?? 'N/A' }}</span>
                        </div>
                        <button class="btn-primary btn-block" style="padding: 0.5rem;" onclick="openDetailModal({{ json_encode($match) }}, {{ json_encode($photos) }}, {{ Auth::user()->is_premium ? 'true' : 'false' }}, {{ in_array($match->id, $sentInterestIds) ? 'true' : 'false' }})"><i class="fas fa-eye"></i> View Full Profile</button>
                    </div>
                </div>
            @empty
                <div class="full-width" style="text-align: center; grid-column: 1 / -1;">
                    <p>No matches found currently. Please check back later or update your preferences.</p>
                </div>
            @endforelse
        </div>
    </section>
    @endauth

    @php
        $heroImage = \App\Models\Setting::get('hero_image');
        $heroStyle = $heroImage ? "background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('".asset('storage/'.$heroImage)."');" : "";
    @endphp
    @guest
    <section class="hero" style="{{ $heroStyle }}">
        <button class="btn-primary" onclick="window.openModal()">Get Started & Find Your Match</button>
    </section>
    @endguest

    <!-- Detail Modal -->
    <div id="detailModal" class="detail-modal">
        <div class="detail-content">
            <div class="close-modal-btn" onclick="closeDetailModal()">
                <i class="fas fa-times"></i>
            </div>
            <div class="detail-grid">
                <div class="detail-photos">
                    <div id="detail-main-photo" class="detail-main-photo"></div>
                    <div class="detail-thumbs-container">
                        <div id="detail-thumbs" class="detail-thumbs"></div>
                    </div>
                </div>
                <div class="detail-info">
                    <div class="detail-header">
                        <h2 id="detail-name"></h2>
                        <div id="detail-quick-stats" style="color: #666; font-size: 1.1rem;"></div>
                    </div>

                    <!-- Identity Section -->
                    <div class="detail-section">
                        <h3><i class="fas fa-user-circle"></i> Basic Identity</h3>
                        <div class="detail-info-grid" id="identity-grid"></div>
                    </div>

                    <!-- Professional Section -->
                    <div class="detail-section">
                        <h3><i class="fas fa-briefcase"></i> Professional Life</h3>
                        <div class="detail-info-grid" id="professional-grid"></div>
                    </div>

                    <!-- Lifestyle Section -->
                    <div class="detail-section">
                        <h3><i class="fas fa-coffee"></i> Lifestyle & Background</h3>
                        <div class="detail-info-grid" id="lifestyle-grid"></div>
                    </div>

                    <!-- Interests Section -->
                    <div class="detail-section">
                        <h3><i class="fas fa-heart"></i> Interests & Personality</h3>
                        <div id="personality-section"></div>
                    </div>

                    <!-- About Me Section -->
                    <div class="detail-section">
                        <h3><i class="fas fa-info-circle"></i> Expectation About Partner</h3>
                        <div id="about-me-section" style="line-height: 1.8; color: #555; background: #fdfdfd; padding: 2rem; border-radius: 20px; border: 1px solid #eee; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word;"></div>
                    </div>

                    <div class="btn-floating">
                        <input type="hidden" id="detail-user-id">
                        <button id="send-interest-btn" class="btn-premium btn-block" style="padding: 1.2rem;" onclick="sendInterest()">
                            <i class="fas fa-paper-plane"></i> Send Interest
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @guest
    <!-- Stats Section -->
    <section class="stats">
        <div class="stat-card">
            <i class="fas fa-users" style="font-size: 2.5rem; color: var(--secondary); margin-bottom: 0.5rem;"></i>
            <h3>{{ \App\Models\Setting::get('stat_active_profiles') ?: '10,000+' }}</h3>
            <p>Active Profiles</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-heart" style="font-size: 2.5rem; color: var(--secondary); margin-bottom: 0.5rem;"></i>
            <h3>{{ \App\Models\Setting::get('stat_success_stories') ?: '5,000+' }}</h3>
            <p>Success Stories</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-check-circle" style="font-size: 2.5rem; color: var(--secondary); margin-bottom: 0.5rem;"></i>
            <h3>{{ \App\Models\Setting::get('stat_verified_profiles') ?: '100%' }}</h3>
            <p>Verified Profiles</p>
        </div>
    </section>
    @endguest

    @guest
    <!-- Features Section -->
    <section class="features" id="about">
        <h2 class="section-title">Why Choose Us?</h2>
        <div class="feature-grid">
            @for($i=1; $i<=3; $i++)
                @php
                    $title = \App\Models\Setting::get("wcu_title_$i") ?: ($i==1 ? 'Community Specific' : ($i==2 ? 'Privacy Protected' : 'Verified Matches'));
                    $desc = \App\Models\Setting::get("wcu_desc_$i") ?: ($i==1 ? 'Tailored exclusively for the Kasar Samaj members worldwide.' : ($i==2 ? 'Your data is secure with us. You control who sees your profile.' : 'Every profile goes through a strict manual verification process.'));
                @endphp
                <div class="feature-card">
                    <i class="fas {{ $i==1 ? 'fa-users' : ($i==2 ? 'fa-shield-alt' : 'fa-user-check') }}" style="font-size: 2.5rem; color: var(--primary); margin-bottom: 1.5rem;"></i>
                    <h3>{{ $title }}</h3>
                    <p>{{ $desc }}</p>
                </div>
            @endfor
        </div>
    </section>

    <!-- Success Stories -->
    <section class="stories" id="stories">
        <h2 class="section-title">Success Stories</h2>
        <div class="story-grid">
            @forelse($stories as $story)
                <div class="story-card">
                    @if($story->photo)
                        <img src="{{ asset('storage/' . $story->photo) }}" alt="{{ $story->couple_name }}">
                    @else
                        <img src="/images/success1.png" alt="Couple Default">
                    @endif
                    <div class="story-content">
                        <h4>{{ $story->couple_name }}</h4>
                        <p>"{{ $story->story }}"</p>
                    </div>
                </div>
            @empty
                @for($i=1; $i<=3; $i++)
                <div class="story-card">
                    <img src="/images/success1.png" alt="Couple {{ $i }}">
                    <div class="story-content">
                        <h4>Couple {{ $i }}</h4>
                        <p>"Found our perfect match within 3 months. Truly grateful to Kasar Matrimony!"</p>
                    </div>
                </div>
                @endfor
            @endforelse
        </div>
    </section>

    <!-- FAQ Section -->
    @if($faqs->count() > 0)
    <section class="faq-section" style="padding: 5rem 10%; background: #fff;">
        <h2 class="section-title">Frequently Asked Questions</h2>
        <div class="faq-grid" style="max-width: 800px; margin: 0 auto;">
            @foreach($faqs as $faq)
                <div class="faq-item" style="margin-bottom: 2rem; border-bottom: 1px solid #eee; padding-bottom: 1rem;">
                    <h3 style="color: var(--primary); margin-bottom: 0.5rem; font-size: 1.2rem;">Q: {{ $faq->question }}</h3>
                    <p style="color: #666; line-height: 1.6;">A: {{ $faq->answer }}</p>
                </div>
            @endforeach
        </div>
    </section>
    @endif
    @endguest

    <!-- Modern Registration/Login Modal -->
    <div id="loginModal" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); backdrop-filter: blur(8px); z-index: 9999; align-items: center; justify-content: center;">
        <div class="modal-content" style="width: 95%; max-width: 500px; padding: 0; border-radius: 24px; overflow: hidden; border: none; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); margin: auto; position: relative; max-height: 90vh; overflow-y: auto;">
            <!-- Modal Header -->
            <div style="padding: 2.5rem; background: white; position: relative;">
                <span class="close" onclick="window.closeModal()" style="top: 20px; right: 25px; font-size: 24px; font-weight: 300;">&times;</span>
                <h2 style="font-size: 2.2rem; margin-bottom: 0.5rem; color: #1a1a1a; font-family: 'Playfair Display', serif;">Register Now &</h2>
                <p style="font-size: 1.2rem; color: #444; margin-bottom: 1.5rem;">Find your perfect life partner</p>
                
                <div style="display: flex; align-items: center; justify-content: flex-end; gap: 10px; margin-bottom: 2rem;">
                    <span style="font-size: 0.9rem; color: #666;">Already a member?</span>
                    <button onclick="window.toggleLoginMode()" id="toggle-btn" style="padding: 8px 20px; border-radius: 50px; border: 1px solid var(--primary); background: transparent; color: var(--primary); font-weight: 600; cursor: pointer; transition: 0.3s;">Log In</button>
                </div>

                <div id="registration-form">
                    <div class="form-group">
                        <select id="created_by" style="width: 100%; padding: 1rem; border: 1px solid #ddd; border-radius: 12px; font-size: 1rem; appearance: none; background: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23666%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E') no-repeat right 1rem center; background-size: 12px auto;">
                            <option value="Self">Profile Created By</option>
                            <option value="Self">Self</option>
                            <option value="Parent">Parent</option>
                            <option value="Sibling">Sibling</option>
                            <option value="Friend">Friend</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label style="font-size: 0.9rem; color: #444; margin-bottom: 0.8rem; font-weight: 600;">Select Gender</label>
                        <div class="gender-container" style="display: flex; gap: 15px;">
                            <button type="button" onclick="window.setGender('Male')" class="gender-btn active" id="gender-male" style="flex: 1; padding: 12px; border-radius: 12px; border: 1px solid #ddd; background: #fff; cursor: pointer; transition: 0.3s; font-weight: 600;">Male</button>
                            <button type="button" onclick="window.setGender('Female')" class="gender-btn" id="gender-female" style="flex: 1; padding: 12px; border-radius: 12px; border: 1px solid #ddd; background: #fff; cursor: pointer; transition: 0.3s; font-weight: 600;">Female</button>
                            <input type="hidden" id="gender" value="Male">
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="text" id="name" placeholder="Name" style="width: 100%; padding: 1rem; border: 1px solid #ddd; border-radius: 12px; font-size: 1rem;">
                    </div>
                </div>

                <div class="form-group">
                    <input type="email" id="email" placeholder="Email Address" required style="width: 100%; padding: 1rem; border: 1px solid #ddd; border-radius: 12px; font-size: 1rem;">
                </div>

                <div class="form-group">
                    <input type="password" id="password" placeholder="Password" required style="width: 100%; padding: 1rem; border: 1px solid #ddd; border-radius: 12px; font-size: 1rem;">
                    <div id="password-requirements" style="font-size: 0.8rem; color: #666; margin-top: 0.5rem; text-align: left; display: none; background: #f9f9f9; padding: 0.8rem; border-radius: 8px; border: 1px solid #eee;">
                        <p style="margin: 0 0 4px 0; font-weight: 600;">Password must contain:</p>
                        <ul style="padding-left: 1.2rem; margin: 0; list-style-type: none;">
                            <li id="req-length" style="color: #dc3545; transition: color 0.3s; margin: 2px 0;">✗ At least 8 characters</li>
                            <li id="req-upper" style="color: #dc3545; transition: color 0.3s; margin: 2px 0;">✗ At least one uppercase letter</li>
                            <li id="req-lower" style="color: #dc3545; transition: color 0.3s; margin: 2px 0;">✗ At least one lowercase letter</li>
                            <li id="req-number" style="color: #dc3545; transition: color 0.3s; margin: 2px 0;">✗ At least one numeric value</li>
                            <li id="req-special" style="color: #dc3545; transition: color 0.3s; margin: 2px 0;">✗ At least one special character</li>
                        </ul>
                    </div>
                </div>

                <div class="form-group" id="confirm-password-group">
                    <input type="password" id="password_confirmation" placeholder="Confirm Password" required style="width: 100%; padding: 1rem; border: 1px solid #ddd; border-radius: 12px; font-size: 1rem;">
                </div>

                <div id="terms-group" style="margin-bottom: 1.5rem; display: flex; gap: 10px; align-items: flex-start;">
                    <input type="checkbox" id="terms_agree" checked style="margin-top: 4px; cursor: pointer;">
                    <label for="terms_agree" style="font-size: 0.8rem; color: #666; line-height: 1.4; cursor: pointer;">
                        By clicking Register Now, you agree to our <a href="{{ route('pages.show', 'terms-of-use') }}" target="_blank" style="color: var(--primary); text-decoration: underline;">Terms & Conditions</a> and <a href="{{ route('pages.show', 'privacy-policy') }}" target="_blank" style="color: var(--primary); text-decoration: underline;">Privacy Policy</a>.
                    </label>
                </div>

                <button class="btn-primary btn-block" id="action-btn" onclick="window.submitAuth()" style="padding: 1.2rem; border-radius: 12px; font-size: 1.1rem; box-shadow: 0 10px 20px rgba(128, 0, 0, 0.2);">Register Now</button>

                <p style="text-align: center; margin-top: 1.5rem; font-size: 0.85rem;">
                    <a href="{{ route('password.request') }}" id="forgot-password-link" style="color: var(--primary); text-decoration: none; display: none; font-weight: 600;">Forgot Password?</a>
                </p>
            </div>
        </div>
    </div>

    <style>
        .gender-btn.active {
            background: var(--primary) !important;
            color: white !important;
            border-color: var(--primary) !important;
        }
        @media (max-width: 480px) {
            .gender-container {
                flex-direction: column !important;
            }
            .modal-content {
                border-radius: 0 !important;
                height: 100vh !important;
                max-height: 100vh !important;
            }
        }
    </style>

    @include('partials.footer')

    <script>
        window.onPageLoad(function() {
            // State Variables
            let isLoginMode = false;
            const modal = document.getElementById("loginModal");
            const notification = document.getElementById("notification");
            const actionBtn = document.getElementById('action-btn');
            const regForm = document.getElementById('registration-form');
            const toggleBtn = document.getElementById('toggle-btn');
            const modalTitle = document.querySelector('#loginModal h2');
            const modalSub = document.querySelector('#loginModal p');

            // Define functions locally
            function openModal() {
                const modalEl = document.getElementById("loginModal");
                if (modalEl) {
                    modalEl.style.display = "flex";
                    return true;
                }
                return false;
            }

            function closeModal() {
                const modalEl = document.getElementById("loginModal");
                if (modalEl) modalEl.style.display = "none";
                resetModal();
            }

            function resetModal() {
                const actionBtnEl = document.getElementById('action-btn');
                if (actionBtnEl) {
                    actionBtnEl.disabled = false;
                    actionBtnEl.innerText = isLoginMode ? 'Log In' : 'Register Now';
                }
                const emailInput = document.getElementById('email');
                const passwordInput = document.getElementById('password');
                const passwordConfirmation = document.getElementById('password_confirmation');
                const reqList = document.getElementById('password-requirements');
                
                if (emailInput) emailInput.value = '';
                if (passwordInput) passwordInput.value = '';
                if (passwordConfirmation) passwordConfirmation.value = '';
                if (reqList) reqList.style.display = 'none';
            }

            function toggleLoginMode() {
                isLoginMode = !isLoginMode;
                const regFormEl = document.getElementById('registration-form');
                const confirmGroup = document.getElementById('confirm-password-group');
                const termsGroup = document.getElementById('terms-group');
                const forgotLink = document.getElementById('forgot-password-link');
                const reqList = document.getElementById('password-requirements');
                const actionBtnEl = document.getElementById('action-btn');
                const toggleBtnEl = document.getElementById('toggle-btn');
                const modalTitleEl = document.querySelector('#loginModal h2');
                const modalSubEl = document.querySelector('#loginModal p');

                if (isLoginMode) {
                    if (regFormEl) regFormEl.style.display = 'none';
                    if (confirmGroup) confirmGroup.style.display = 'none';
                    if (termsGroup) termsGroup.style.display = 'none';
                    if (forgotLink) forgotLink.style.display = 'inline-block';
                    if (reqList) reqList.style.display = 'none';
                    
                    if (actionBtnEl) actionBtnEl.innerText = 'Log In';
                    if (toggleBtnEl) toggleBtnEl.innerText = 'Register';
                    if (modalTitleEl) modalTitleEl.innerText = 'Welcome Back';
                    if (modalSubEl) modalSubEl.innerText = 'Log in to find your partner';
                } else {
                    if (regFormEl) regFormEl.style.display = 'block';
                    if (confirmGroup) confirmGroup.style.display = 'block';
                    if (termsGroup) termsGroup.style.display = 'flex';
                    if (forgotLink) forgotLink.style.display = 'none';
                    
                    if (actionBtnEl) actionBtnEl.innerText = 'Register Now';
                    if (toggleBtnEl) toggleBtnEl.innerText = 'Log In';
                    if (modalTitleEl) modalTitleEl.innerText = 'Register Now &';
                    if (modalSubEl) modalSubEl.innerText = 'Find your perfect life partner';
                }
                
                // Clear fields on toggle
                const emailInput = document.getElementById('email');
                const passwordInput = document.getElementById('password');
                const passwordConfirmation = document.getElementById('password_confirmation');
                
                if (emailInput) emailInput.value = '';
                if (passwordInput) passwordInput.value = '';
                if (passwordConfirmation) passwordConfirmation.value = '';
            }

            function setGender(gender) {
                document.getElementById('gender').value = gender;
                document.querySelectorAll('.gender-btn').forEach(btn => btn.classList.remove('active'));
                if (gender === 'Male') document.getElementById('gender-male').classList.add('active');
                else document.getElementById('gender-female').classList.add('active');
            }

            // Password Real-time Validator
            const passwordInput = document.getElementById('password');
            const reqList = document.getElementById('password-requirements');
            const reqLength = document.getElementById('req-length');
            const reqUpper = document.getElementById('req-upper');
            const reqLower = document.getElementById('req-lower');
            const reqNumber = document.getElementById('req-number');
            const reqSpecial = document.getElementById('req-special');

            if (passwordInput) {
                passwordInput.addEventListener('focus', function() {
                    if (!isLoginMode) {
                        reqList.style.display = 'block';
                    }
                });

                passwordInput.addEventListener('blur', function() {
                    if (passwordInput.value === '') {
                        reqList.style.display = 'none';
                    }
                });

                passwordInput.addEventListener('input', function() {
                    if (isLoginMode) return;
                    const val = passwordInput.value;

                    // Length >= 8
                    if (val.length >= 8) {
                        reqLength.style.color = '#28a745';
                        reqLength.innerHTML = '✓ At least 8 characters';
                    } else {
                        reqLength.style.color = '#dc3545';
                        reqLength.innerHTML = '✗ At least 8 characters';
                    }

                    // Uppercase
                    if (/[A-Z]/.test(val)) {
                        reqUpper.style.color = '#28a745';
                        reqUpper.innerHTML = '✓ At least one uppercase letter';
                    } else {
                        reqUpper.style.color = '#dc3545';
                        reqUpper.innerHTML = '✗ At least one uppercase letter';
                    }

                    // Lowercase
                    if (/[a-z]/.test(val)) {
                        reqLower.style.color = '#28a745';
                        reqLower.innerHTML = '✓ At least one lowercase letter';
                    } else {
                        reqLower.style.color = '#dc3545';
                        reqLower.innerHTML = '✗ At least one lowercase letter';
                    }

                    // Number
                    if (/[0-9]/.test(val)) {
                        reqNumber.style.color = '#28a745';
                        reqNumber.innerHTML = '✓ At least one numeric value';
                    } else {
                        reqNumber.style.color = '#dc3545';
                        reqNumber.innerHTML = '✗ At least one numeric value';
                    }

                    // Special character
                    if (/[!@#$%^&*(),.?":{}|<>]/.test(val)) {
                        reqSpecial.style.color = '#28a745';
                        reqSpecial.innerHTML = '✓ At least one special character';
                    } else {
                        reqSpecial.style.color = '#dc3545';
                        reqSpecial.innerHTML = '✗ At least one special character';
                    }
                });
            }

            // Password Authentication Submit Logic
            async function submitAuth() {
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;

                if (!email) return showNotification('Please enter email', 'error');
                if (!password) return showNotification('Please enter password', 'error');

                if (actionBtn) actionBtn.disabled = true;

                if (isLoginMode) {
                    if (actionBtn) actionBtn.innerText = 'Logging in...';
                    try {
                        const response = await fetch("{{ route('login.submit') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ email, password })
                        });
                        const data = await response.json();
                        
                        if (response.ok && data.success) {
                            showNotification(data.message, 'success');
                            setTimeout(() => window.location.href = data.redirect, 800);
                        } else {
                            showNotification(data.message || 'Invalid credentials', 'error');
                            if (actionBtn) {
                                actionBtn.disabled = false;
                                actionBtn.innerText = 'Log In';
                            }
                        }
                    } catch (err) {
                        showNotification('Connection error. Try again.', 'error');
                        if (actionBtn) {
                            actionBtn.disabled = false;
                            actionBtn.innerText = 'Log In';
                        }
                    }
                } else {
                    // Register Mode
                    const termsChecked = document.getElementById('terms_agree').checked;
                    if (!termsChecked) return showNotification('Please agree to the Terms and Conditions', 'error');

                    const nameInput = document.getElementById('name');
                    const genderInput = document.getElementById('gender');
                    const createdByInput = document.getElementById('created_by');
                    const passwordConfirmation = document.getElementById('password_confirmation').value;
                    
                    const name = nameInput ? nameInput.value : '';
                    const gender = genderInput ? genderInput.value : '';
                    const created_by = createdByInput ? createdByInput.value : '';

                    if (!name) {
                        if (actionBtn) actionBtn.disabled = false;
                        return showNotification('Please enter name', 'error');
                    }
                    
                    // Client-side quick password validation
                    if (password.length < 8 || !/[A-Z]/.test(password) || !/[a-z]/.test(password) || !/[0-9]/.test(password) || !/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
                        if (actionBtn) actionBtn.disabled = false;
                        return showNotification('Password does not meet all complexity requirements.', 'error');
                    }

                    if (password !== passwordConfirmation) {
                        if (actionBtn) actionBtn.disabled = false;
                        return showNotification('Passwords do not match', 'error');
                    }

                    if (actionBtn) actionBtn.innerText = 'Registering...';
                    try {
                        const response = await fetch("{{ route('register') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                name,
                                email,
                                password,
                                password_confirmation: passwordConfirmation,
                                gender,
                                profile_created_by: created_by
                            })
                        });
                        const data = await response.json();
                        if (response.ok) {
                            showNotification('Registration successful!', 'success');
                            setTimeout(() => window.location.href = data.redirect, 800);
                        } else {
                            let errMsg = data.message;
                            if (data.errors) {
                                const firstErrorKey = Object.keys(data.errors)[0];
                                errMsg = data.errors[firstErrorKey][0];
                            }
                            showNotification(errMsg || 'Registration failed', 'error');
                            if (actionBtn) {
                                actionBtn.disabled = false;
                                actionBtn.innerText = 'Register Now';
                            }
                        }
                    } catch (err) {
                        showNotification('Connection error. Try again.', 'error');
                        if (actionBtn) {
                            actionBtn.disabled = false;
                            actionBtn.innerText = 'Register Now';
                        }
                    }
                }
            }

            function showNotification(msg, type) {
                if (!notification) return;
                notification.innerText = msg;
                notification.className = `notification ${type}`;
                notification.style.display = "block";
                notification.style.zIndex = "100000";
                setTimeout(() => { notification.style.display = "none"; }, 3000);
            }

            // Expose functions globally on window object
            window.openModal = openModal;
            window.closeModal = closeModal;
            window.resetModal = resetModal;
            window.toggleLoginMode = toggleLoginMode;
            window.setGender = setGender;
            window.submitAuth = submitAuth;
            window.showNotification = showNotification;

            // Auto-popup logic
            @guest
                @if(request()->has('show_login'))
                    setTimeout(() => {
                        openModal();
                        toggleLoginMode();
                    }, 100);
                @else
                    setTimeout(() => {
                        if (!sessionStorage.getItem('popupShown')) {
                            openModal();
                            sessionStorage.setItem('popupShown', 'true');
                        }
                    }, 3000);
                @endif
            @endguest

            // Global Click Listeners
            window.onclick = function(event) {
                if (event.target == modal) closeModal();
            };

            document.getElementById('login-btn-header')?.addEventListener('click', openModal);
        });

        // Other utility functions
        function changePhoto(matchId, url) {
            document.getElementById(`main-photo-${matchId}`).style.backgroundImage = `url('${url}')`;
        }

        function openDetailModal(user, photos, isPremium, alreadySent) {
            // Track Profile View
            fetch(`/track-view/${user.id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const profile = user.profile;
            const detailModal = document.getElementById('detailModal');
            
            // Premium/Verified Name Display
            let nameHtml = user.name;
            if (profile.is_verified) {
                nameHtml += ` <span class="verified-badge ${user.is_premium ? 'gold' : ''}" title="Verified Profile" style="width: 24px; height: 24px; font-size: 0.8rem; margin-left: 12px;"><i class="fas fa-check"></i></span>`;
            }
            document.getElementById('detail-name').innerHTML = nameHtml;
            document.getElementById('detail-user-id').value = user.id;
            
            const quickStats = document.getElementById('detail-quick-stats');
            quickStats.innerHTML = `<i class="fas fa-map-marker-alt"></i> ${profile.city || 'N/A'}, ${profile.state || 'N/A'} • <i class="fas fa-graduation-cap"></i> ${profile.education || 'N/A'}`;

            const sendBtn = document.getElementById('send-interest-btn');
            if (alreadySent) {
                sendBtn.innerHTML = '<i class="fas fa-check-circle"></i> Interest Sent';
                sendBtn.disabled = true;
                sendBtn.style.opacity = '0.7';
            } else {
                sendBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Send Interest';
                sendBtn.disabled = false;
                sendBtn.style.opacity = '1';
            }

            const mainPhotoDiv = document.getElementById('detail-main-photo');
            const thumbsDiv = document.getElementById('detail-thumbs');
            thumbsDiv.innerHTML = '';
            const defaultPhoto = `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=800000&color=fff&size=500`;
            const mainPhotoUrl = photos.length > 0 ? `/storage/${photos[0]}` : defaultPhoto;
            mainPhotoDiv.style.backgroundImage = `url('${mainPhotoUrl}')`;

            photos.forEach((photo, index) => {
                const thumb = document.createElement('div');
                thumb.className = 'detail-thumb' + (index === 0 ? ' active' : '');
                thumb.style.backgroundImage = `url('/storage/${photo}')`;
                thumb.onclick = () => {
                    mainPhotoDiv.style.backgroundImage = `url('/storage/${photo}')`;
                    document.querySelectorAll('.detail-thumb').forEach(t => t.classList.remove('active'));
                    thumb.classList.add('active');
                };
                thumbsDiv.appendChild(thumb);
            });

            const renderPills = (data) => data.map(item => `<div class="info-pill"><label>${item.label}</label><span>${item.value}</span></div>`).join('');
            
            let phoneHtml = isPremium ? `<a href="tel:${profile.phone_number || ''}" style="color: var(--primary); text-decoration: none; font-weight: bold;">📞 ${profile.phone_number || 'Not provided'}</a>` : `<span style="filter: blur(3px); user-select: none;">+91 XXXXX XXXXX</span> <a href="{{ route('plans') }}" style="color: var(--primary); font-size: 0.7rem; text-decoration: underline;">Upgrade</a>`;

            const identity = [
                { label: 'Full Name', value: user.name }, { label: 'Phone', value: phoneHtml },
                { label: 'Age', value: profile.dob ? calculateAge(profile.dob) + ' Years' : 'N/A' },
                { label: 'Marital Status', value: profile.marital_status || 'N/A' },
                { label: 'Height', value: profile.height || 'N/A' }, { label: 'Gender', value: profile.gender || 'N/A' }
            ];

            const professional = [
                { label: 'Education', value: profile.education || 'N/A' }, { label: 'Occupation', value: profile.occupation || 'N/A' },
                { label: 'Annual Income', value: profile.annual_income || 'N/A' }, { label: 'Location', value: (profile.city || 'N/A') + ', ' + (profile.state || 'N/A') }
            ];

            const lifestyle = [
                { label: 'Family Type', value: profile.family_type || 'N/A' }, { label: 'Mangalik', value: profile.mangalik || 'N/A' },
                { label: 'Food Pref.', value: profile.food_preference || 'N/A' }, { label: 'Smoking', value: profile.smoking_habit || 'N/A' },
                { label: 'Drinking', value: profile.drinking_habit || 'N/A' }, { label: 'Accessibility', value: profile.is_physically_challenged || 'N/A' }
            ];

            document.getElementById('identity-grid').innerHTML = renderPills(identity);
            document.getElementById('professional-grid').innerHTML = renderPills(professional);
            document.getElementById('lifestyle-grid').innerHTML = renderPills(lifestyle);

            const personalityDiv = document.getElementById('personality-section');
            let personalityHtml = '<div style="margin-bottom: 1.5rem;">';
            if (profile.describe_words?.length) {
                personalityHtml += '<p style="font-weight: 600; color: #777; margin-bottom: 10px; font-size: 0.8rem; text-transform: uppercase;">Words that describe me:</p>';
                personalityHtml += profile.describe_words.map(w => `<span class="detail-tag">${w}</span>`).join('');
            }
            personalityHtml += '</div><div>';
            if (profile.interests?.length) {
                personalityHtml += '<p style="font-weight: 600; color: #777; margin-bottom: 10px; font-size: 0.8rem; text-transform: uppercase;">Interests:</p>';
                personalityHtml += profile.interests.map(i => `<span class="detail-tag">${i}</span>`).join('');
            }
            personalityHtml += '</div>';
            personalityDiv.innerHTML = (profile.describe_words || profile.interests) ? personalityHtml : 'No personality details provided.';
            document.getElementById('about-me-section').innerText = profile.about_me || 'This user has not written a detailed description yet.';

            detailModal.style.display = "flex";
            detailModal.style.alignItems = "center";
            detailModal.style.justifyContent = "center";
        }

        function closeDetailModal() { document.getElementById("detailModal").style.display = "none"; }

        async function sendInterest() {
            const receiverId = document.getElementById('detail-user-id').value;
            const btn = document.getElementById('send-interest-btn');
            btn.innerText = 'Sending...'; btn.disabled = true;
            try {
                const response = await fetch("/send-interest", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: JSON.stringify({ receiver_id: receiverId })
                });
                const data = await response.json();
                if (data.success) { showNotification(data.message, 'success'); btn.innerText = 'Interest Sent'; btn.style.background = '#28a745'; }
                else { showNotification(data.message, 'error'); btn.innerText = 'Send Interest'; btn.disabled = false; }
            } catch (err) { showNotification('Something went wrong', 'error'); btn.innerText = 'Send Interest'; btn.disabled = false; }
        }

        function calculateAge(dob) {
            const birthDate = new Date(dob);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) age--;
            return age;
        }

        function toggleLike(userId, event) {
            if (event) event.stopPropagation();
            fetch(`/like/${userId}`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }
            }).then(r => r.json()).then(data => {
                if (data.success) {
                    const btn = document.getElementById(`like-${userId}`);
                    const icon = btn.querySelector('i');
                    if (data.liked) { btn.classList.add('active'); icon.classList.replace('far', 'fas'); }
                    else { btn.classList.remove('active'); icon.classList.replace('fas', 'far'); }
                    showNotification(data.message, 'success');
                } else {
                    showNotification(data.message, 'error');
                    if (data.message.includes('premium')) setTimeout(() => window.location.href = "{{ route('plans') }}", 1500);
                }
            });
        }
    </script>
</body>
</html>
