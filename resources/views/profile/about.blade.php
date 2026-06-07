<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Me & Interests | Kasar Community Matrimony</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #800000 0%, #a00000 100%);
            --gold-gradient: linear-gradient(135deg, #D4AF37 0%, #F1D479 100%);
            --shadow-sm: 0 2px 4px rgba(0,0,0,0.05);
            --shadow-md: 0 10px 30px rgba(0,0,0,0.08);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .profile-container {
            margin-top: 0;
            padding: 4rem 5%;
            background: #fdfaf5;
            background-image: radial-gradient(#80000005 1px, transparent 1px);
            background-size: 20px 20px;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .profile-header h1 {
            color: var(--primary);
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            margin-bottom: 1rem;
            letter-spacing: -0.5px;
        }

        .profile-header p {
            font-size: 1.1rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }

        .edit-section-card {
            background: white;
            padding: 2.5rem;
            border-radius: 24px;
            box-shadow: var(--shadow-md);
            margin-bottom: 2.5rem;
            border: 1px solid rgba(0,0,0,0.03);
            transition: var(--transition);
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            color: var(--primary);
            font-size: 1.6rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 15px;
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 1rem;
        }

        .section-title i {
            width: 40px;
            height: 40px;
            background: #fff5f5;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 1.2rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.8rem;
        }

        @media (max-width: 768px) {
            .form-grid { grid-template-columns: 1fr; }
            .profile-header h1 { font-size: 2.2rem; }
        }

        .form-group label {
            font-weight: 600;
            color: #555;
            margin-bottom: 0.8rem;
            display: block;
            font-size: 1rem;
        }

        .form-group select, 
        .form-group textarea {
            width: 100%;
            padding: 0.9rem 1.2rem;
            border: 2px solid #f0f0f0;
            border-radius: 14px;
            font-size: 1rem;
            font-family: 'Outfit', sans-serif;
            background: #fcfcfc;
            transition: var(--transition);
        }

        .form-group textarea { height: 180px; resize: none; }

        .form-group select:focus, 
        .form-group textarea:focus {
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 4px rgba(128, 0, 0, 0.05);
            outline: none;
        }

        .full-width { grid-column: 1 / -1; }

        .tag-cloud {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 0.5rem;
        }

        .tag-item {
            display: none;
        }

        .tag-label {
            padding: 0.6rem 1.4rem;
            background: #f8f9fa;
            border: 2px solid #eee;
            border-radius: 50px;
            cursor: pointer;
            font-size: 0.95rem;
            font-weight: 500;
            transition: var(--transition);
            user-select: none;
            color: #666;
        }

        .tag-label:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: #fffafa;
        }

        .tag-item:checked + .tag-label {
            background: var(--primary-gradient);
            color: white;
            border-color: var(--primary);
            box-shadow: 0 4px 10px rgba(128, 0, 0, 0.2);
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 2.5rem;
            color: #888;
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            font-size: 1.05rem;
        }

        .back-link:hover {
            color: var(--primary);
            transform: translateX(-5px);
        }

        .btn-premium {
            background: var(--primary-gradient);
            color: white;
            padding: 1.2rem 4rem;
            border-radius: 50px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 8px 20px rgba(128, 0, 0, 0.2);
            transition: var(--transition);
        }

        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(128, 0, 0, 0.3);
        }
    </style>
</head>
<body>
    @include('partials.recovery-banner')

    @include('partials.header')

    <div class="profile-container">
        <div style="max-width: 900px; margin: 0 auto;">
            <a href="{{ route('profile.edit') }}" class="back-link"><i class="fas fa-arrow-left"></i> Basic Details</a>
            
            <div class="profile-header">
                <h1>Partner Expectations</h1>
                <p>Express your unique personality and lifestyle choices to help others know you better.</p>
            </div>

            <form action="{{ route('profile.about.update') }}" method="POST">
                @csrf
                
                <!-- Personality & Description -->
                <div class="edit-section-card">
                    <div class="section-title">
                        <i class="fas fa-magic"></i>
                        Personality & Bio
                    </div>
                    
                    <div class="form-group full-width" style="margin-bottom: 2.5rem;">
                        <label><i class="fas fa-quote-left" style="color: var(--primary); margin-right: 8px;"></i> 3 Words that define you (Choose 3)</label>
                        <div class="tag-cloud">
                            @php
                                $words = ['Smart', 'Family Oriented', 'Loving', 'Kind', 'Caring', 'Humble', 'Fun', 'Empathetic', 'Confident', 'Creative'];
                                $selectedWords = old('describe_words', $profile->describe_words ?: []);
                            @endphp
                            @foreach($words as $word)
                                <input type="checkbox" name="describe_words[]" value="{{ $word }}" id="word-{{ $word }}" class="tag-item" {{ in_array($word, $selectedWords) ? 'checked' : '' }}>
                                <label for="word-{{ $word }}" class="tag-label">{{ $word }}</label>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label for="about_me"><i class="fas fa-feather-alt" style="color: var(--primary); margin-right: 8px;"></i> Expectation About Partner</label>
                        <textarea name="about_me" placeholder="Describe what you are looking for in your life partner (e.g., personality, values, career)..." required>{{ old('about_me', $profile->about_me) }}</textarea>
                        @error('about_me') <span style="color: #dc3545; font-size: 0.8rem;">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Interests -->
                <div class="edit-section-card">
                    <div class="section-title">
                        <i class="fas fa-heart"></i>
                        My Hobbies & Interests
                    </div>
                    <div class="tag-cloud">
                        @php
                            $interests = ['Walking', 'Running', 'Swimming', 'Singing', 'Reading', 'Dancing', 'Drawing', 'Travelling', 'Painting', 'Gym', 'Photography', 'Writing', 'Baking', 'Cooking', 'Gardening', 'Pets'];
                            $selectedInterests = old('interests', $profile->interests ?: []);
                        @endphp
                        @foreach($interests as $interest)
                            <input type="checkbox" name="interests[]" value="{{ $interest }}" id="interest-{{ $interest }}" class="tag-item" {{ in_array($interest, $selectedInterests) ? 'checked' : '' }}>
                            <label for="interest-{{ $interest }}" class="tag-label">{{ $interest }}</label>
                        @endforeach
                    </div>
                </div>

                <!-- Lifestyle -->
                <div class="edit-section-card">
                    <div class="section-title">
                        <i class="fas fa-glass-cheers"></i>
                        Lifestyle Choices
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label><i class="fas fa-utensils"></i> Food Preference</label>
                            <select name="food_preference">
                                <option value="">Select Preference</option>
                                <option value="Vegetarian" {{ old('food_preference', $profile->food_preference) == 'Vegetarian' ? 'selected' : '' }}>Vegetarian</option>
                                <option value="Non-Vegetarian" {{ old('food_preference', $profile->food_preference) == 'Non-Vegetarian' ? 'selected' : '' }}>Non-Vegetarian</option>
                                <option value="No Preference" {{ old('food_preference', $profile->food_preference) == 'No Preference' ? 'selected' : '' }}>No Preference</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-smoking"></i> Smoking Habit</label>
                            <select name="smoking_habit">
                                <option value="">Select Option</option>
                                <option value="Never" {{ old('smoking_habit', $profile->smoking_habit) == 'Never' ? 'selected' : '' }}>Never</option>
                                <option value="Socially" {{ old('smoking_habit', $profile->smoking_habit) == 'Socially' ? 'selected' : '' }}>Socially</option>
                                <option value="Regularly" {{ old('smoking_habit', $profile->smoking_habit) == 'Regularly' ? 'selected' : '' }}>Regularly</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-glass-martini-alt"></i> Drinking Habit</label>
                            <select name="drinking_habit">
                                <option value="">Select Option</option>
                                <option value="Never" {{ old('drinking_habit', $profile->drinking_habit) == 'Never' ? 'selected' : '' }}>Never</option>
                                <option value="Socially" {{ old('drinking_habit', $profile->drinking_habit) == 'Socially' ? 'selected' : '' }}>Socially</option>
                                <option value="Regularly" {{ old('drinking_habit', $profile->drinking_habit) == 'Regularly' ? 'selected' : '' }}>Regularly</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-wheelchair"></i> Accessibility Needs</label>
                            <select name="is_physically_challenged">
                                <option value="">Select Option</option>
                                <option value="No" {{ old('is_physically_challenged', $profile->is_physically_challenged) == 'No' ? 'selected' : '' }}>No</option>
                                <option value="Yes" {{ old('is_physically_challenged', $profile->is_physically_challenged) == 'Yes' ? 'selected' : '' }}>Yes</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Family & Astro -->
                <div class="edit-section-card">
                    <div class="section-title">
                        <i class="fas fa-users"></i>
                        Background & Astro
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label><i class="fas fa-home"></i> Family Type</label>
                            <select name="family_type">
                                <option value="">Select Type</option>
                                <option value="Nuclear Family" {{ old('family_type', $profile->family_type) == 'Nuclear Family' ? 'selected' : '' }}>Nuclear Family</option>
                                <option value="Joint Family" {{ old('family_type', $profile->family_type) == 'Joint Family' ? 'selected' : '' }}>Joint Family</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-star-and-crescent"></i> Mangalik Status</label>
                            <select name="mangalik">
                                <option value="">Select Option</option>
                                <option value="No" {{ old('mangalik', $profile->mangalik) == 'No' ? 'selected' : '' }}>No</option>
                                <option value="Yes" {{ old('mangalik', $profile->mangalik) == 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="Don't Know" {{ old('mangalik', $profile->mangalik) == "Don't Know" ? 'selected' : '' }}>Don't Know</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div style="text-align: center; margin-top: 4rem;">
                    <button type="submit" class="btn-premium"><i class="fas fa-save"></i> Complete My Story</button>
                </div>
            </form>
        </div>
    </div>

    @include('partials.footer')

    <script>
        // Limit Describe Words to 3
        const wordCheckboxes = document.querySelectorAll('input[name="describe_words[]"]');
        wordCheckboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                const checkedCount = document.querySelectorAll('input[name="describe_words[]"]:checked').length;
                if (checkedCount > 3) {
                    cb.checked = false;
                    // Custom aesthetic alert
                    const toast = document.createElement('div');
                    toast.style.cssText = 'position: fixed; top: 20px; right: 20px; background: #dc3545; color: white; padding: 1rem 2rem; border-radius: 12px; z-index: 10000; box-shadow: 0 10px 30px rgba(0,0,0,0.1); animation: slideIn 0.3s forwards;';
                    toast.innerText = 'Please select up to 3 words only.';
                    document.body.appendChild(toast);
                    setTimeout(() => {
                        toast.style.opacity = '0';
                        toast.style.transition = '0.5s';
                        setTimeout(() => toast.remove(), 500);
                    }, 3000);
                }
            });
        });

        // Mobile Menu Toggle
        const mobileMenu = document.getElementById('mobile-menu');
        const closeMenu = document.getElementById('close-menu');
        const navLinks = document.querySelector('.nav-links');

        mobileMenu?.addEventListener('click', () => navLinks.classList.add('active'));
        closeMenu?.addEventListener('click', () => navLinks.classList.remove('active'));
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => navLinks.classList.remove('active'));
        });
    </script>
    <style>
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    </style>
</body>
</html>
