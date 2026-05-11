<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Kasar Matrimony</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #8B0000; --secondary: #f4f7f6; }
        body {
            font-family: 'Outfit', sans-serif;
            background: var(--secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .login-card {
            background: white;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .logo { color: var(--primary); font-size: 2rem; font-weight: 700; margin-bottom: 2rem; display: block; text-decoration: none; }
        .form-group { margin-bottom: 1.5rem; text-align: left; }
        label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: #444; }
        input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-sizing: border-box;
            font-size: 1rem;
        }
        .btn-login {
            background: var(--primary);
            color: white;
            border: none;
            width: 100%;
            padding: 1rem;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 1rem;
        }
        .btn-login:hover { opacity: 0.9; transform: translateY(-2px); }
        .error-msg { color: #dc3545; background: #ffe6e6; padding: 0.8rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem; }
    </style>
</head>
<body>
    <div class="login-card">
        <a href="/" class="logo">
            <img src="/images/logo-icon.png" alt="Logo" style="height: 60px; width: 60px; border-radius: 50%; border: 2px solid var(--secondary); margin: 0 auto 1rem; display: block;">
            Kasar Matrimony
        </a>
        <h2>Admin Login</h2>
        <p style="color: #666; margin-bottom: 2rem;">Please sign in to access the control panel</p>

        @if(session('error'))
            <div class="error-msg">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="error-msg">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" required placeholder="admin@kasarmatrimony.com" value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="••••••••">
            </div>
            <button type="submit" class="btn-login">Login to Dashboard</button>
            <div style="margin-top: 1.5rem; display: flex; justify-content: center; font-size: 0.9rem;">
                <a href="{{ route('password.request') }}" style="color: var(--primary); text-decoration: none;">Forgot Password?</a>
            </div>
        </form>

        <a href="/" style="display: block; margin-top: 2rem; color: #888; text-decoration: none; font-size: 0.9rem;">← Back to Home Page</a>
    </div>
</body>
</html>
