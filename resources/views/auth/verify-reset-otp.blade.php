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
                <input type="password" name="password" id="password" placeholder="Min. 8 characters" required>
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

            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Repeat password" required>
            </div>

            <button type="submit" class="btn-recovery">Reset Password</button>
        </form>

        <div style="margin-top: 2rem; border-top: 1px solid #eee; padding-top: 1.5rem;">
            <a href="{{ route('password.request') }}" style="color: #888; text-decoration: none; font-size: 0.9rem;">Resend OTP</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const reqList = document.getElementById('password-requirements');
            const reqLength = document.getElementById('req-length');
            const reqUpper = document.getElementById('req-upper');
            const reqLower = document.getElementById('req-lower');
            const reqNumber = document.getElementById('req-number');
            const reqSpecial = document.getElementById('req-special');

            if (passwordInput) {
                passwordInput.addEventListener('focus', function() {
                    reqList.style.display = 'block';
                });

                passwordInput.addEventListener('blur', function() {
                    if (passwordInput.value === '') {
                        reqList.style.display = 'none';
                    }
                });

                passwordInput.addEventListener('input', function() {
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

            // Client side validation on form submission
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const val = passwordInput.value;
                    const confirmationInput = document.getElementById('password_confirmation');
                    
                    if (val.length < 8 || !/[A-Z]/.test(val) || !/[a-z]/.test(val) || !/[0-9]/.test(val) || !/[!@#$%^&*(),.?":{}|<>]/.test(val)) {
                        e.preventDefault();
                        alert('Password does not meet all complexity requirements.');
                        return;
                    }
                    
                    if (confirmationInput && val !== confirmationInput.value) {
                        e.preventDefault();
                        alert('Passwords do not match.');
                        return;
                    }
                });
            }
        });
    </script>
</body>
</html>
