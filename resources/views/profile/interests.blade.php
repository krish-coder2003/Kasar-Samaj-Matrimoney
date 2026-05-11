<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Interests | Kasar Samaj Matrimony</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #800000 0%, #a00000 100%);
            --secondary-gradient: linear-gradient(135deg, #D4AF37 0%, #F1D479 100%);
            --shadow-sm: 0 2px 4px rgba(0,0,0,0.05);
            --shadow-md: 0 10px 30px rgba(0,0,0,0.08);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            background-color: #fdfaf5;
        }

        .interests-container {
            padding: 120px 5% 4rem;
            min-height: 80vh;
            max-width: 1200px;
            margin: 0 auto;
        }

        .interests-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .interests-header h1 {
            color: var(--primary);
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            margin-bottom: 0.5rem;
            font-weight: 800;
        }

        .interests-header p {
            color: #666;
            font-size: 1.1rem;
        }

        .tabs-wrapper {
            background: white;
            padding: 8px;
            border-radius: 50px;
            display: inline-flex;
            margin-bottom: 3rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid #f0f0f0;
            position: relative;
            left: 50%;
            transform: translateX(-50%);
        }

        .tab {
            padding: 12px 35px;
            cursor: pointer;
            font-weight: 700;
            color: #555;
            border-radius: 50px;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1rem;
            letter-spacing: 0.5px;
        }

        .tab i { font-size: 0.9rem; }

        .tab.active {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 5px 15px rgba(128, 0, 0, 0.2);
        }

        .connection-card {
            background: white;
            padding: 1.8rem;
            border-radius: 24px;
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0,0,0,0.02);
            transition: var(--transition);
        }

        .connection-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
            border-color: rgba(128, 0, 0, 0.1);
        }

        .user-photo {
            width: 110px;
            height: 110px;
            border-radius: 24px;
            background-size: cover;
            background-position: center 20%;
            margin-right: 2rem;
            border: 4px solid #fff;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            flex-shrink: 0;
        }

        .user-info {
            flex-grow: 1;
        }

        .user-info h3 {
            font-family: 'Playfair Display', serif;
            color: var(--primary);
            font-size: 1.8rem;
            margin-bottom: 0.3rem;
            font-weight: 700;
        }

        .user-info .meta {
            display: flex;
            gap: 20px;
            color: #444;
            font-size: 1rem;
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .user-info .meta span {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .status-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending { background: #fff8e1; color: #f57c00; }
        .status-accepted { background: #e8f5e9; color: #2e7d32; }
        .status-declined { background: #ffebee; color: #c62828; }

        .actions-group {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .btn-action {
            padding: 10px 20px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
            border: none;
            text-decoration: none;
        }

        .btn-accept { background: #2e7d32; color: white; }
        .btn-accept:hover { background: #1b5e20; transform: scale(1.05); }

        .btn-decline { background: #fdf2f2; color: #c62828; }
        .btn-decline:hover { background: #fee2e2; }

        .btn-message { background: var(--primary-gradient); color: white; }
        .btn-message:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(128, 0, 0, 0.2); }

        .btn-discard {
            background: #f8f9fa;
            color: #888;
            padding: 10px;
            border-radius: 12px;
            transition: var(--transition);
        }

        .btn-discard:hover {
            background: #fee2e2;
            color: #c62828;
        }

        .empty-state {
            text-align: center;
            padding: 5rem 2rem;
            background: white;
            border-radius: 32px;
            border: 1px solid #f0f0f0;
        }

        .empty-state i {
            font-size: 4rem;
            color: #eee;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 768px) {
            .interests-container { padding: 100px 15px 4rem; }
            .interests-header { margin-bottom: 2.5rem; }
            .interests-header h1 { font-size: 2.2rem; }
            .connection-card { flex-direction: column; text-align: center; padding: 2rem 1.2rem; border-radius: 20px; }
            .user-photo { margin-right: 0; margin-bottom: 1.2rem; width: 100px; height: 100px; }
            .user-info .meta { justify-content: center; flex-wrap: wrap; gap: 8px; margin-bottom: 0.8rem; }
            .actions-group { width: 100%; display: flex; align-items: center; gap: 10px; margin-top: 1.5rem; }
            .actions-group form { display: contents; } /* Allow form children to participate in flex */
            .btn-action { flex: 1; height: 46px; justify-content: center; padding: 0 15px; font-size: 0.9rem; border-radius: 12px; }
            .btn-discard { 
                width: 46px; height: 46px; min-width: 46px; display: flex; align-items: center; justify-content: center; 
                padding: 0; border: 1px solid #eee; background: #fff; border-radius: 12px; color: #888;
                transition: 0.3s;
            }
            .tabs-wrapper { width: 100%; display: flex; border-radius: 15px; overflow: hidden; }
            .tab { padding: 12px 10px; flex: 1; font-size: 0.85rem; justify-content: center; }
        }
    </style>
</head>
<body>
    @include('partials.recovery-banner')

    @include('partials.header')

    <div class="interests-container">
        <div class="interests-header">
            <h1>My Connections</h1>
            <p>Manage your relationship interests and start meaningful conversations.</p>
        </div>
        
        <div class="tabs-wrapper">
            <div class="tab active" id="received-tab-btn" onclick="showTab('received')">
                <i class="fas fa-inbox"></i> Received <span style="opacity: 0.6; margin-left: 4px;">({{ count($receivedInterests) }})</span>
            </div>
            <div class="tab" id="sent-tab-btn" onclick="showTab('sent')">
                <i class="fas fa-paper-plane"></i> Sent <span style="opacity: 0.6; margin-left: 4px;">({{ count($sentInterests) }})</span>
            </div>
        </div>

        <!-- Received Tab Content -->
        <div id="received-tab" class="tab-content">
            @forelse($receivedInterests as $interest)
                <div class="connection-card">
                    <div class="user-photo" style="background-image: url('{{ $interest->sender->profile->photo1 ? asset('storage/' . $interest->sender->profile->photo1) : 'https://ui-avatars.com/api/?name=' . urlencode($interest->sender->name) }}');"></div>
                    <div class="user-info">
                        <h3>
                            {{ $interest->sender->name }}
                            @if($interest->sender->profile->is_verified)
                                <span class="verified-badge {{ $interest->sender->is_premium ? 'gold' : '' }}" title="Verified Profile">
                                    <i class="fas fa-check"></i>
                                </span>
                            @endif
                        </h3>
                        <div class="meta">
                            <span><i class="fas fa-briefcase"></i> {{ $interest->sender->profile->occupation ?: 'Professional' }}</span>
                            <span><i class="fas fa-map-marker-alt"></i> {{ $interest->sender->profile->city ?: 'Location unknown' }}</span>
                        </div>
                        <span class="status-chip status-{{ $interest->status }}">
                            <i class="fas {{ $interest->status == 'accepted' ? 'fa-check-circle' : ($interest->status == 'declined' ? 'fa-times-circle' : 'fa-clock') }}"></i>
                            {{ ucfirst($interest->status) }}
                        </span>
                    </div>

                    <div class="actions-group">
                        @if($interest->status == 'accepted')
                            <a href="{{ route('chat.index', $interest->sender->id) }}" class="btn-action btn-message">
                                <i class="fas fa-comments"></i> Message
                            </a>
                        @elseif($interest->status == 'pending')
                            <form action="{{ route('interests.update', $interest) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="accepted">
                                <button type="submit" class="btn-action btn-accept"><i class="fas fa-check"></i> Accept</button>
                            </form>
                            <form action="{{ route('interests.update', $interest) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="declined">
                                <button type="submit" class="btn-action btn-decline"><i class="fas fa-times"></i> Decline</button>
                            </form>
                        @endif

                        <form action="{{ route('interests.destroy', $interest) }}" method="POST" onsubmit="return confirm('Discard this connection?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-discard" title="Discard">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h2>No Received Interests</h2>
                    <p style="color: #888;">Complete your profile to attract more matches!</p>
                </div>
            @endforelse
        </div>

        <!-- Sent Tab Content -->
        <div id="sent-tab" class="tab-content" style="display: none;">
            @forelse($sentInterests as $interest)
                <div class="connection-card">
                    <div class="user-photo" style="background-image: url('{{ $interest->receiver->profile->photo1 ? asset('storage/' . $interest->receiver->profile->photo1) : 'https://ui-avatars.com/api/?name=' . urlencode($interest->receiver->name) }}');"></div>
                    <div class="user-info">
                        <h3>
                            {{ $interest->receiver->name }}
                            @if($interest->receiver->profile->is_verified)
                                <span class="verified-badge {{ $interest->receiver->is_premium ? 'gold' : '' }}" title="Verified Profile">
                                    <i class="fas fa-check"></i>
                                </span>
                            @endif
                        </h3>
                        <div class="meta">
                            <span><i class="fas fa-briefcase"></i> {{ $interest->receiver->profile->occupation ?: 'Professional' }}</span>
                            <span><i class="fas fa-map-marker-alt"></i> {{ $interest->receiver->profile->city ?: 'Location unknown' }}</span>
                        </div>
                        <span class="status-chip status-{{ $interest->status }}">
                            <i class="fas {{ $interest->status == 'accepted' ? 'fa-check-circle' : ($interest->status == 'declined' ? 'fa-times-circle' : 'fa-clock') }}"></i>
                            {{ ucfirst($interest->status) }}
                        </span>
                    </div>

                    <div class="actions-group">
                        @if($interest->status == 'accepted')
                            <a href="{{ route('chat.index', $interest->receiver->id) }}" class="btn-action btn-message">
                                <i class="fas fa-comments"></i> Message
                            </a>
                        @endif

                        <form action="{{ route('interests.destroy', $interest) }}" method="POST" onsubmit="return confirm('Cancel this interest?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-discard" title="Cancel">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-paper-plane"></i>
                    <h2>No Sent Interests</h2>
                    <p style="color: #888;">Browse profiles and send an interest to start a connection.</p>
                    <a href="{{ route('home') }}#matches" class="btn-premium" style="display: inline-flex; text-decoration: none; margin-top: 2rem;">Explore Matches</a>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        function showTab(type) {
            document.querySelectorAll('.tab-content').forEach(t => t.style.display = 'none');
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            
            document.getElementById(`${type}-tab`).style.display = 'block';
            document.getElementById(`${type}-tab-btn`).classList.add('active');
        }

        // Auto-hide notifications
        setTimeout(() => {
            const notifications = document.querySelectorAll('.notification');
            notifications.forEach(notif => {
                notif.style.opacity = '0';
                setTimeout(() => notif.style.display = 'none', 500);
            });
        }, 2000);
    </script>

    @include('partials.footer')
</body>
</html>
