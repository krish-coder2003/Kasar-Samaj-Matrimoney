<header id="main-header" class="{{ (request()->routeIs('home') && !Auth::check()) ? '' : 'scrolled' }}" data-auth="{{ Auth::check() ? 'true' : 'false' }}">
    <a href="{{ route('home') }}" class="logo">
        <img src="/images/logo-icon.png" alt="Kasar Community Logo">
        <div class="logo-text">
            <span class="brand-name">Kasar Community</span>
            <span class="brand-sub">Matrimony</span>
        </div>
    </a>
    
    <nav class="nav-links">
        <div class="close-menu" id="close-menu">
            <i class="fas fa-times"></i>
        </div>
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}"><i class="fas fa-home"></i> Home</a>
        @guest
            <a href="{{ route('home') }}#about"><i class="fas fa-info-circle"></i> About</a>
            <a href="{{ route('home') }}#stories"><i class="fas fa-heart"></i> Success Stories</a>
            <a href="#" onclick="typeof window.openModal === 'function' ? window.openModal() : window.location.href='{{ route('login') }}'" class="hidden-desktop">
                <i class="fas fa-sign-in-alt"></i> Login / Register
            </a>
        @endguest
        @auth
            <a href="{{ route('interests.index') }}" class="{{ request()->routeIs('interests.*') ? 'active' : '' }}"><i class="fas fa-star"></i> My Interests</a>
            <a href="{{ route('profile.visitors') }}" class="{{ request()->routeIs('profile.visitors') ? 'active' : '' }}"><i class="fas fa-eye"></i> Who Viewed Me</a>
            @if(Auth::user()->is_premium)
                <a href="{{ route('profile.liked-me') }}" class="{{ request()->routeIs('profile.liked-me') ? 'active' : '' }}"><i class="fas fa-heart" style="color: #e74c3c;"></i> Liked Me</a>
            @endif
            <a href="{{ route('chat.index') }}" class="{{ request()->routeIs('chat.*') ? 'active' : '' }}"><i class="fas fa-comments"></i> Chat</a>
            <a href="{{ route('profile.edit') }}" class="hidden-desktop {{ request()->routeIs('profile.edit') ? 'active' : '' }}"><i class="fas fa-user-edit"></i> My Profile</a>
            @if(!Auth::user()->is_premium)
                <a href="{{ route('plans') }}" class="{{ request()->routeIs('plans') ? 'active' : '' }}" style="color: #D4AF37; font-weight: bold;"><i class="fas fa-crown"></i> Upgrade</a>
            @endif
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-common').submit();" class="hidden-desktop" style="color: #e74c3c; font-weight: 600;">
                <i class="fas fa-power-off"></i> Logout
            </a>
        @endauth
    </nav>

    <div class="header-actions">
        @guest
            <a href="#" id="login-btn-header" class="btn-premium-nav" onclick="typeof window.openModal === 'function' ? window.openModal() : window.location.href='{{ route('login') }}'">
                <i class="fas fa-sign-in-alt"></i> Login / Register
            </a>
        @else
            <!-- Notification Bell -->
            <div class="notification-wrapper" id="notification-wrapper">
                <div class="notification-bell" id="notification-bell">
                    <i class="fas fa-bell"></i>
                    <span class="unread-count" id="unread-count" style="display: none;">0</span>
                </div>
                <div class="notification-dropdown" id="notification-dropdown">
                    <div class="notif-header">Notifications</div>
                    <div class="notif-list" id="notif-list">
                        <div class="notif-empty">No new notifications</div>
                    </div>
                    <a href="{{ route('profile.visitors') }}" class="notif-footer">View All Visitors</a>
                </div>
            </div>

            @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="btn-premium-nav" style="margin-right: 0.8rem;">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            @endif

            <a href="{{ route('profile.edit') }}" class="btn-premium-nav {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                <i class="fas fa-user"></i> My Profile
            </a>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-common').submit();" class="btn-logout" title="Logout">
                <i class="fas fa-power-off"></i>
            </a>
        @endauth
    </div>

    <div class="menu-toggle" id="mobile-menu">
        <i class="fas fa-bars"></i>
    </div>
</header>

@auth
    <form id="logout-form-common" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
@endauth

<script>
    // Unified Header Scroll Effect
    window.addEventListener('scroll', function() {
        const header = document.getElementById('main-header');
        @if(request()->routeIs('home') && !Auth::check())
            header.classList.toggle('scrolled', window.scrollY > 50);
        @endif
    });

    // Unified Mobile Menu Logic
    document.addEventListener('turbo:load', function() {
        const mobileMenu = document.getElementById('mobile-menu');
        const closeMenu = document.getElementById('close-menu');
        const navLinks = document.querySelector('.nav-links');

        if (mobileMenu && navLinks) {
            mobileMenu.addEventListener('click', () => {
                navLinks.classList.add('active');
            });
        }

        if (closeMenu && navLinks) {
            closeMenu.addEventListener('click', () => {
                navLinks.classList.remove('active');
            });
        }
    });
</script>

<style>
    .notification-wrapper { position: relative; margin-right: 1rem; }
    .notification-bell { 
        width: 45px; height: 45px; background: rgba(128, 0, 0, 0.05); 
        border-radius: 50%; display: flex; align-items: center; justify-content: center; 
        cursor: pointer; position: relative; transition: 0.3s; color: var(--primary);
        border: 1px solid rgba(128, 0, 0, 0.1);
    }
    .notification-bell:hover { background: rgba(128, 0, 0, 0.1); transform: scale(1.05); }
    .unread-count { 
        position: absolute; top: -5px; right: -5px; background: #e74c3c; 
        color: white; font-size: 0.7rem; font-weight: 800; padding: 2px 6px; 
        border-radius: 50px; border: 2px solid white; box-shadow: 0 4px 10px rgba(231, 76, 60, 0.3);
    }
    .notification-dropdown { 
        position: absolute; top: 120%; right: 0; width: 320px; 
        background: white; border-radius: 20px; box-shadow: 0 15px 50px rgba(0,0,0,0.15); 
        display: none; flex-direction: column; overflow: hidden; z-index: 3000;
        border: 1px solid rgba(0,0,0,0.05); animation: slideInNotif 0.3s ease;
    }
    @keyframes slideInNotif { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .notification-dropdown.active { display: flex; }
    .notif-header { padding: 1.2rem; font-weight: 800; border-bottom: 1px solid #f5f5f5; color: var(--primary); font-size: 1rem; }
    .notif-list { max-height: 400px; overflow-y: auto; }
    .notif-item { 
        padding: 1.2rem; display: flex; align-items: center; gap: 12px; 
        border-bottom: 1px solid #f9f9f9; text-decoration: none; color: #444; transition: 0.3s;
    }
    .notif-item:hover { background: #fffcfc; }
    .notif-item.unread { background: #fff5f5; }
    .notif-actor-photo { width: 45px; height: 45px; border-radius: 12px; background-size: cover; background-position: center; flex-shrink: 0; }
    .notif-content { flex-grow: 1; }
    .notif-content p { font-size: 0.85rem; margin: 0; line-height: 1.4; }
    .notif-content span { font-size: 0.7rem; color: #999; }
    .notif-empty { padding: 3rem 1.5rem; text-align: center; color: #888; font-size: 0.9rem; }
    .notif-footer { padding: 1rem; text-align: center; background: #fafafa; font-size: 0.85rem; font-weight: 700; color: var(--primary); text-decoration: none; }
    .notif-footer:hover { background: #f0f0f0; }
</style>

@auth
<script>
    document.addEventListener('turbo:load', function() {
        const bell = document.getElementById('notification-bell');
        if (!bell) return;

        const dropdown = document.getElementById('notification-dropdown');
        const unreadBadge = document.getElementById('unread-count');
        const notifList = document.getElementById('notif-list');
        const isPremium = {{ Auth::user()->is_premium ? 'true' : 'false' }};

        async function fetchNotifications() {
            try {
                const response = await fetch('/api/notifications');
                const data = await response.json();
                
                if (data.success) {
                    // Update Badge
                    if (data.unread_count > 0) {
                        unreadBadge.innerText = data.unread_count;
                        unreadBadge.style.display = 'block';
                    } else {
                        unreadBadge.style.display = 'none';
                    }

                    // Update List
                    if (data.notifications.length > 0) {
                        let html = '';
                        data.notifications.forEach(notif => {
                            const photo = notif.actor && notif.actor.profile && notif.actor.profile.photo1 
                                ? `/storage/${notif.actor.profile.photo1}` 
                                : `https://ui-avatars.com/api/?name=${encodeURIComponent(notif.actor ? notif.actor.name : 'User')}`;
                            
                            const link = isPremium ? `/home?search_user=${notif.actor_id}` : '/visitors';
                            const actorName = isPremium ? (notif.actor ? notif.actor.name : 'Someone') : 'Someone';
                            
                            html += `
                                <a href="${link}" class="notif-item ${notif.is_read ? '' : 'unread'}">
                                    <div class="notif-actor-photo" style="background-image: url('${photo}'); ${!isPremium ? 'filter: blur(5px);' : ''}"></div>
                                    <div class="notif-content">
                                        <p><strong>${actorName}</strong> viewed your profile!</p>
                                        <span>${new Date(notif.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>
                                    </div>
                                </a>
                            `;
                        });
                        notifList.innerHTML = html;
                    }
                }
            } catch (err) { console.error('Notification fetch error:', err); }
        }

        bell.addEventListener('click', async (e) => {
            e.stopPropagation();
            dropdown.classList.toggle('active');
            
            if (dropdown.classList.contains('active')) {
                // Mark as read
                fetch('/api/notifications/mark-read', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                        'Content-Type': 'application/json'
                    }
                });
                unreadBadge.style.display = 'none';
            }
        });

        document.addEventListener('click', () => dropdown.classList.remove('active'));
        dropdown.addEventListener('click', (e) => e.stopPropagation());

        fetchNotifications();
        setInterval(fetchNotifications, 30000); // Every 30s
    });
</script>
@endauth

@auth
    @if(Auth::user()->isAdmin())
        <div class="admin-floating-badge">
            <a href="{{ route('admin.dashboard') }}" class="btn-admin-floating">
                <i class="fas fa-arrow-left"></i> Admin Dashboard
            </a>
        </div>
        <style>
            .admin-floating-badge {
                position: fixed;
                bottom: 30px;
                left: 30px;
                z-index: 9999;
            }
            .btn-admin-floating {
                display: inline-flex;
                align-items: center;
                gap: 10px;
                background: linear-gradient(135deg, #800000 0%, #b30000 100%);
                color: white !important;
                text-decoration: none !important;
                padding: 1rem 1.8rem;
                border-radius: 50px;
                font-family: 'Outfit', sans-serif;
                font-weight: 700;
                font-size: 1rem;
                box-shadow: 0 10px 25px rgba(128, 0, 0, 0.4);
                border: 2px solid #D4AF37;
                transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                cursor: pointer;
            }
            .btn-admin-floating:hover {
                transform: translateY(-5px) scale(1.05);
                box-shadow: 0 15px 30px rgba(128, 0, 0, 0.5);
                background: linear-gradient(135deg, #a00000 0%, #d60000 100%);
                color: #D4AF37 !important;
            }
            .btn-admin-floating i {
                font-size: 1.1rem;
                transition: transform 0.3s ease;
            }
            .btn-admin-floating:hover i {
                transform: translateX(-4px);
            }
            @media (max-width: 768px) {
                .admin-floating-badge {
                    bottom: 20px;
                    left: 20px;
                }
                .btn-admin-floating {
                    padding: 0.8rem 1.4rem;
                    font-size: 0.9rem;
                }
            }
        </style>
    @endif
@endauth
