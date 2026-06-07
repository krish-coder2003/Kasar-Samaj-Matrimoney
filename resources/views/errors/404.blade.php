<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found | Kasar Community Matrimony</title>
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
            background: #fdfaf5;
            padding: 2rem;
        }
        .error-code {
            font-size: 10rem;
            font-weight: 800;
            color: var(--primary);
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
        .btn-home {
            background: var(--primary);
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
            box-shadow: 0 10px 20px rgba(128, 0, 0, 0.2);
        }
        .btn-home:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(128, 0, 0, 0.3);
        }
    </style>
</head>
<body>

    <div class="error-container">
        <div class="error-code">404</div>
        <div class="error-content">
            <h1>Lost in the Journey?</h1>
            <p>We couldn't find the page you're looking for. It might have been moved or doesn't exist anymore.</p>
            <a href="{{ route('home') }}" class="btn-home">Return to Home</a>
        </div>
    </div>

</body>
</html>
