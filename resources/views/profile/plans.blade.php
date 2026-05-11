<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upgrade Plans | Kasar Samaj Matrimony</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .plans-container {
            margin-top: 0;
            padding: 5rem 10%;
            background: #fdfaf5;
            text-align: center;
        }
        .plans-header h1 {
            color: var(--primary);
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .plans-header p {
            color: #666;
            font-size: 1.2rem;
            margin-bottom: 4rem;
        }
        .plans-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .plan-card {
            background: white;
            padding: 3rem 2rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: 0.3s;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .plan-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .plan-card.featured {
            border: 2px solid var(--secondary);
            transform: scale(1.05);
            z-index: 10;
        }
        .plan-card.featured:hover {
            transform: scale(1.05) translateY(-10px);
        }
        .badge {
            position: absolute;
            top: 20px;
            right: -35px;
            background: var(--secondary);
            color: white;
            padding: 5px 40px;
            transform: rotate(45deg);
            font-size: 0.8rem;
            font-weight: bold;
        }
        .plan-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1rem;
        }
        .plan-price {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 2rem;
        }
        .plan-price span {
            font-size: 1rem;
            color: #888;
            font-weight: 400;
        }
        .plan-features {
            list-style: none;
            margin-bottom: 3rem;
            text-align: left;
            flex-grow: 1;
        }
        .plan-features li {
            margin-bottom: 1rem;
            color: #555;
            display: flex;
            align-items: center;
        }
        .plan-features li i {
            color: var(--secondary);
            margin-right: 10px;
            width: 20px;
        }
        .plan-features li.disabled i {
            color: #ccc;
        }
        .plan-btn {
            width: 100%;
            padding: 1rem;
            border-radius: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: 0.3s;
        }
    </style>
</head>
<body>
    @include('partials.recovery-banner')

    @include('partials.header')

    <div class="plans-container">
        <div class="plans-header">
            <h1><i class="fas fa-crown" style="color: var(--secondary);"></i> Choose Your Perfect Plan</h1>
            <p>Connect with your soulmate faster with our premium features.</p>
        </div>

        <div class="plans-grid">
            <!-- Basic Plan -->
            <div class="plan-card">
                <div class="plan-name">Basic</div>
                <div class="plan-price">Free</div>
                <ul class="plan-features">
                    <li><i class="fas fa-user-plus"></i> Create Profile</li>
                    <li><i class="fas fa-camera"></i> Add 3 Photos</li>
                    <li><i class="fas fa-search"></i> Browse Profiles</li>
                    <li class="disabled"><i class="fas fa-phone-slash"></i> View Contact Numbers</li>
                    <li class="disabled"><i class="fas fa-mobile-alt"></i> Direct Calling</li>
                    <li class="disabled"><i class="fas fa-rocket"></i> Profile Boosting</li>
                </ul>
                <button class="plan-btn" style="background: #eee; color: #777; cursor: default;">Current Plan</button>
            </div>

            <!-- Gold Plan -->
            <div class="plan-card featured">
                <div class="badge">POPULAR</div>
                <div class="plan-name">Gold Member</div>
                <div class="plan-price">₹1,499 <span>/ 3 Months</span></div>
                <ul class="plan-features">
                    <li><i class="fas fa-check-double"></i> Everything in Basic</li>
                    <li><i class="fas fa-id-card"></i> View Contact Numbers</li>
                    <li><i class="fas fa-phone-volume"></i> Direct Calling Feature</li>
                    <li><i class="fas fa-paper-plane"></i> Send Unlimited Interests</li>
                    <li><i class="fas fa-certificate"></i> Blue Verification Badge</li>
                    <li class="disabled"><i class="fas fa-crown"></i> Elite Spotlight Boosting</li>
                </ul>
                <form action="{{ route('upgrade') }}" method="POST">
                    @csrf
                    <button type="submit" class="plan-btn btn-primary" style="background: var(--secondary); border-color: var(--secondary);">Upgrade to Gold</button>
                </form>
            </div>

            <!-- Platinum Plan -->
            <div class="plan-card">
                <div class="plan-name">Platinum</div>
                <div class="plan-price">₹2,999 <span>/ 6 Months</span></div>
                <ul class="plan-features">
                    <li><i class="fas fa-check-double"></i> Everything in Gold</li>
                    <li><i class="fas fa-crown"></i> Elite Spotlight Boosting</li>
                    <li><i class="fas fa-arrow-up"></i> Top Search Results</li>
                    <li><i class="fas fa-user-tie"></i> Personal Relationship Manager</li>
                    <li><i class="fas fa-bolt"></i> Express Interests</li>
                    <li><i class="fas fa-calendar-star"></i> Access to Private Events</li>
                </ul>
                <form action="{{ route('upgrade') }}" method="POST">
                    @csrf
                    <button type="submit" class="plan-btn btn-primary">Upgrade to Platinum</button>
                </form>
            </div>
        </div>

        <div style="margin-top: 6rem; background: white; padding: 4rem 2rem; border-radius: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); max-width: 1000px; margin-left: auto; margin-right: auto;">
            <h2 style="color: var(--primary); font-family: 'Playfair Display', serif; margin-bottom: 2rem;">Why Get Verified?</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 3rem; text-align: left;">
                <div>
                    <i class="fas fa-shield-alt" style="font-size: 2rem; color: #00b4db; margin-bottom: 1rem;"></i>
                    <h4 style="margin-bottom: 0.5rem;">Build Instant Trust</h4>
                    <p style="color: #666; font-size: 0.9rem;">Profiles with a Blue Badge get 5x more interests and responses.</p>
                </div>
                <div>
                    <i class="fas fa-eye" style="font-size: 2rem; color: #D4AF37; margin-bottom: 1rem;"></i>
                    <h4 style="margin-bottom: 0.5rem;">Higher Visibility</h4>
                    <p style="color: #666; font-size: 0.9rem;">Verified profiles are prioritized in search results and match suggestions.</p>
                </div>
                <div>
                    <i class="fas fa-user-check" style="font-size: 2rem; color: #2e7d32; margin-bottom: 1rem;"></i>
                    <h4 style="margin-bottom: 0.5rem;">Genuine Matching</h4>
                    <p style="color: #666; font-size: 0.9rem;">Show your future partner that you are serious and authentic.</p>
                </div>
            </div>
            <button class="btn-premium" style="margin-top: 3rem; border-radius: 50px; padding: 1rem 3rem;">Get Verified Now - ₹499</button>
        </div>
    </div>

    <script>
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
