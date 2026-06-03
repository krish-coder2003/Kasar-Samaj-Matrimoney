<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') | Kasar Samaj Matrimony</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --admin-bg: #f4f7f6; --sidebar-w: 280px; }
        body { background: var(--admin-bg); font-family: 'Outfit', sans-serif; display: flex; min-height: 100vh; margin: 0; }
        
        .sidebar {
            width: var(--sidebar-w);
            height: 100vh;
            background: #1a1a1a;
            color: white;
            padding: 2rem;
            position: fixed;
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }
        
        .sidebar .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            margin-bottom: 2.5rem;
            padding: 0.8rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: 0.3s;
        }
        .sidebar .logo:hover { background: rgba(255, 255, 255, 0.1); }
        
        .sidebar .logo img { height: 40px; width: 40px; border-radius: 8px; background: white; padding: 2px; }
        
        .sidebar .logo-text { display: flex; flex-direction: column; line-height: 1.1; }
        .sidebar .brand-name { font-size: 1.1rem; font-weight: 800; color: white; }
        .sidebar .brand-sub { font-size: 0.7rem; color: #aaa; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; }

        .sidebar-links { flex-grow: 1; overflow-y: auto; }
        .sidebar-links::-webkit-scrollbar { width: 4px; }
        .sidebar-links::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }

        .sidebar-links a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #aaa;
            text-decoration: none;
            margin-bottom: 0.8rem;
            font-weight: 500;
            padding: 0.8rem 1.2rem;
            border-radius: 10px;
            transition: 0.3s;
        }
        
        .sidebar-links a i { width: 20px; text-align: center; font-size: 1.1rem; }
        .sidebar-links a:hover, .sidebar-links a.active { background: rgba(255,255,255,0.1); color: white; }
        .sidebar-links a.active { background: #800000; color: white; box-shadow: 0 4px 15px rgba(128, 0, 0, 0.3); }

        .sidebar-footer { border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1.5rem; margin-top: 1rem; }
        .btn-logout-sidebar {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #ff7675;
            text-decoration: none;
            font-weight: 600;
            padding: 0.8rem 1.2rem;
            border-radius: 10px;
            transition: 0.3s;
            width: 100%;
            background: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
            font-size: 1rem;
        }
        .btn-logout-sidebar:hover { background: rgba(214, 48, 49, 0.1); color: #d63031; }

        .main-content {
            margin-left: var(--sidebar-w);
            flex: 1;
            padding: 3rem;
            width: calc(100% - var(--sidebar-w));
            min-height: 100vh;
        }

        /* Admin Components */
        .admin-card { background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); margin-bottom: 2rem; }
        .btn-primary-admin { background: #800000; color: white; border: none; padding: 0.8rem 1.5rem; border-radius: 8px; cursor: pointer; font-weight: 600; text-decoration: none; transition: 0.3s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-primary-admin:hover { background: #a00000; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(128, 0, 0, 0.2); }
        
        /* Visibility classes */
        .desktop-only { display: block !important; }
        .mobile-only { display: none !important; }

        @media (max-width: 1024px) {
            body { flex-direction: column !important; }
            .sidebar { 
                width: 100% !important; 
                height: auto !important; 
                position: relative !important; 
                padding: 1.2rem !important;
                border-radius: 0 0 20px 20px;
                flex-direction: column;
            }
            .sidebar .logo { margin-bottom: 1.2rem !important; margin-right: 0; }
            .sidebar-links { display: flex !important; overflow-x: auto !important; gap: 8px; padding-bottom: 8px; width: 100%; }
            .sidebar-links::-webkit-scrollbar { display: none; }
            .sidebar-links a { margin-bottom: 0 !important; white-space: nowrap !important; padding: 0.6rem 1rem !important; border-radius: 50px; font-size: 0.9rem; }
            .sidebar-footer { display: none; } /* Hide logout footer on mobile, add it to the horizontal list */
            .mobile-logout { display: flex !important; color: #ff7675 !important; }
            
            .main-content { margin-left: 0 !important; padding: 1.5rem !important; width: 100% !important; }
            .desktop-only { display: none !important; }
            .mobile-only { display: block !important; }
        }
        
        @yield('styles')
    </style>

    <!-- Hotwire Turbo -->
    <script src="https://cdn.jsdelivr.net/npm/@hotwired/turbo@8.0.4/dist/turbo.es2017-umd.js"></script>
</head>
<body>
    <div class="sidebar">
        <a href="{{ route('home') }}" class="logo">
            <img src="/images/logo-icon.png" alt="Logo">
            <div class="logo-text">
                <span class="brand-name">Kasar Samaj</span>
                <span class="brand-sub">Matrimony</span>
            </div>
        </a>
        
        <div class="sidebar-links">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Manage Users
            </a>
            <a href="{{ route('admin.verifications') }}" class="{{ request()->routeIs('admin.verifications') ? 'active' : '' }}">
                <i class="fas fa-id-card"></i> Verifications
            </a>
            <a href="{{ route('admin.stories') }}" class="{{ request()->routeIs('admin.stories*') ? 'active' : '' }}">
                <i class="fas fa-heart"></i> Success Stories
            </a>
            <a href="{{ route('admin.faqs') }}" class="{{ request()->routeIs('admin.faqs*') ? 'active' : '' }}">
                <i class="fas fa-question-circle"></i> Manage FAQs
            </a>
            <a href="{{ route('admin.legal') }}" class="{{ request()->routeIs('admin.legal') ? 'active' : '' }}">
                <i class="fas fa-file-contract"></i> Legal Pages
            </a>
            <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                <i class="fas fa-cog"></i> Site Settings
            </a>
            <a href="{{ route('home') }}">
                <i class="fas fa-globe"></i> Back to Website
            </a>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-admin').submit();" style="color: #ff7675; margin-top: auto; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 1.5rem;">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
            <form id="logout-form-admin" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        </div>

    </div>

    <div class="main-content">
        @yield('content')
    </div>

    @yield('scripts')
</body>
</html>
