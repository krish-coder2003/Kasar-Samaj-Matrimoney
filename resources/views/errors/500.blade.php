<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Error | Kasar Samaj Matrimony</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <style>
        .error-container {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            background: #fffafa;
            padding: 2rem;
        }
        .error-code {
            font-size: 10rem;
            font-weight: 800;
            color: #888;
            line-height: 1;
            margin-bottom: 1rem;
            opacity: 0.1;
            position: absolute;
            z-index: 0;
        }
        .error-content {
            position: relative;
            z-index: 1;
        }
        .error-content h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
        }
        .error-content p {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 3rem;
            max-width: 500px;
        }
        .btn-retry {
            background: #2c3e50;
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
            cursor: pointer;
            border: none;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .btn-retry:hover {
            transform: translateY(-3px);
            background: #1a252f;
        }
    </style>
</head>
<body>

    <div class="error-container">
        <div class="error-code">500</div>
        <div class="error-content">
            <h1>Unexpected Glitch</h1>
            <p>Something went wrong on our end. We've been notified and are working to fix it as soon as possible. Please try again in a moment.</p>
            <button onclick="window.location.reload()" class="btn-retry">Try Again</button>
            <div style="margin-top: 2rem;">
                <a href="{{ route('home') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Return to Homepage</a>
            </div>
        </div>
    </div>

</body>
</html>
