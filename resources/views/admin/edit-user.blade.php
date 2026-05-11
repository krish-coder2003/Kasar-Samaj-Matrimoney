<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User | Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <style>
        body { display: flex; background: #f4f7f6; }
        .sidebar {
            width: 280px;
            height: 100vh;
            background: var(--primary);
            color: white;
            padding: 2rem;
            position: fixed;
        }
        .sidebar h2 { margin-bottom: 3rem; font-family: 'Playfair Display', serif; }
        .sidebar-links a {
            display: block;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            margin-bottom: 1.5rem;
            font-weight: 500;
            transition: 0.3s;
        }
        .sidebar-links a:hover, .sidebar-links a.active { color: white; transform: translateX(10px); }
        
        .main-content {
            margin-left: 280px;
            width: calc(100% - 280px);
            padding: 3rem;
        }
        .admin-card {
            background: white;
            padding: 3rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            max-width: 600px;
        }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #444; }
        .form-group input, .form-group select { width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 8px; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Admin Panel</h2>
        <div class="sidebar-links">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.users') }}" class="active">Manage Users</a>
            <a href="{{ route('home') }}">Back to Website</a>
        </div>
    </div>

    <div class="main-content">
        <h1>Edit User: {{ $user->name }}</h1>
        <p style="color: #888; margin-bottom: 3rem;">Modify account permissions and details</p>

        <div class="admin-card">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" value="{{ $user->name }}" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" value="{{ $user->email }}" required>
                </div>
                <div class="form-group">
                    <label>User Role</label>
                    <select name="role">
                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Regular User</option>
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrator</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Premium Status</label>
                    <select name="is_premium">
                        <option value="0" {{ !$user->is_premium ? 'selected' : '' }}>Standard Member</option>
                        <option value="1" {{ $user->is_premium ? 'selected' : '' }}>Premium Member</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary btn-block">Save User Changes</button>
            </form>
        </div>
    </div>

</body>
</html>
