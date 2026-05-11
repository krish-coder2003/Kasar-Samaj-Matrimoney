<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Found | Kasar Matrimony</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <style>
        body { background: #fdfaf5; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
        .recovery-card { background: white; padding: 3rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); width: 100%; max-width: 450px; text-align: center; }
        .alert-success { background: #dcfce7; color: #166534; padding: 1.5rem; border-radius: 15px; margin-top: 1rem; font-size: 1.2rem; font-weight: 700; border: 2px solid #b9f6ca; }
    </style>
</head>
<body>
    <div class="recovery-card">
        <a href="/" style="color: var(--primary); font-size: 1.8rem; font-weight: 700; text-decoration: none; margin-bottom: 1rem; display: flex; flex-direction: column; align-items: center; gap: 10px;">
            <img src="/images/logo-icon.png" alt="Logo" style="height: 70px; width: 70px; border-radius: 50%; border: 2px solid var(--secondary);">
            Kasar Matrimony
        </a>
        <h2>Account Found!</h2>
        <p style="color: #666; margin-bottom: 2rem;">Your registered email address is:</p>

        <div class="alert-success">
            {{ $email }}
        </div>

        <div style="margin-top: 2rem; border-top: 1px solid #eee; padding-top: 1.5rem;">
            <a href="/" class="btn-primary" style="display: inline-block; text-decoration: none; width: 100%; box-sizing: border-box;">Go to Login</a>
        </div>
    </div>
</body>
</html>
