<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Reset OTP | Kasar Matrimony</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <style>
        body { background: #fdfaf5; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
        .recovery-card { background: white; padding: 3rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); width: 100%; max-width: 450px; text-align: center; }
        .form-group { margin-bottom: 1.5rem; text-align: left; }
        label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: #444; }
        input { width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 10px; box-sizing: border-box; font-size: 1rem; }
        .btn-recovery { background: var(--primary); color: white; border: none; width: 100%; padding: 1rem; border-radius: 10px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: 0.3s; margin-top: 1rem; }
        .btn-recovery:hover { opacity: 0.9; transform: translateY(-2px); }
        .alert { padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem; font-size: 0.9rem; }
        .alert-error { background: #fee2e2; color: #991b1b; }
        .alert-success { background: #dcfce7; color: #166534; }
    </style>
</head>
<body>
    <div class="recovery-card">
        <a href="/" style="color: var(--primary); font-size: 1.8rem; font-weight: 700; text-decoration: none; margin-bottom: 1rem; display: flex; flex-direction: column; align-items: center; gap: 10px;">
            <img src="/images/logo-icon.png" alt="Logo" style="height: 70px; width: 70px; border-radius: 50%; border: 2px solid var(--secondary);">
            Kasar Matrimony
        </a>
        <h2>Reset Your Password</h2>
        <p style="color: #666; margin-bottom: 2rem;">Verification OTP sent to <strong>{{ $email }}</strong></p>
        
        @if(session('otp'))
            <div class="alert alert-success" style="background: #fff3cd; color: #856404; border: 1px solid #ffeeba;">
                <strong>Test Mode:</strong> Your OTP is <strong>{{ session('otp') }}</strong>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            
            <div class="form-group">
                <label>Enter 6-Digit OTP</label>
                <input type="text" name="otp" placeholder="123456" required maxlength="6">
            </div>

            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="password" placeholder="Min. 6 characters" required>
            </div>

            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" name="password_confirmation" placeholder="Repeat password" required>
            </div>

            <button type="submit" class="btn-recovery">Reset Password</button>
        </form>

        <div style="margin-top: 2rem; border-top: 1px solid #eee; padding-top: 1.5rem;">
            <a href="{{ route('password.request') }}" style="color: #888; text-decoration: none; font-size: 0.9rem;">Resend OTP</a>
        </div>
    </div>
</body>
</html>
