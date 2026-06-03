@extends('layouts.app')

@section('title', 'Edit Profile | Kasar Samaj Matrimony')

@section('header_class', 'scrolled')

@section('styles')
    <style>
        .profile-container { padding: 120px 5% 4rem; background: #fdfaf5; background-image: radial-gradient(#80000005 1px, transparent 1px); background-size: 20px 20px; }
        .profile-header { text-align: center; margin-bottom: 4rem; }
        .profile-header h1 { color: var(--primary); font-family: 'Playfair Display', serif; font-size: 3rem; margin-bottom: 1rem; letter-spacing: -0.5px; }
        .profile-header p { font-size: 1.1rem; color: #666; max-width: 600px; margin: 0 auto; }
        .edit-section-card { background: white; padding: 2.5rem; border-radius: 24px; box-shadow: var(--shadow-md); margin-bottom: 2.5rem; border: 1px solid rgba(0,0,0,0.03); transition: var(--transition); }
        .edit-section-card:hover { transform: translateY(-5px); box-shadow: 0 15px 40px rgba(0,0,0,0.1); }
        .section-title { font-family: 'Playfair Display', serif; color: var(--primary); font-size: 1.6rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 15px; border-bottom: 1px solid #f0f0f0; padding-bottom: 1rem; }
        .section-title i { width: 40px; height: 40px; background: #fff5f5; color: var(--primary); display: flex; align-items: center; justify-content: center; border-radius: 12px; font-size: 1.2rem; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.8rem; }
        @media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; } .profile-header h1 { font-size: 2.2rem; } .photo-upload-grid { grid-template-columns: repeat(2, 1fr); gap: 1rem; } .profile-container { padding-top: 100px; } }
        @media (max-width: 480px) { .photo-upload-grid { grid-template-columns: 1fr; } .profile-container { padding: 90px 15px 3rem; } .edit-section-card { padding: 1.5rem; border-radius: 16px; } .section-title { font-size: 1.3rem; } }
        .form-group label { font-weight: 600; color: #555; margin-bottom: 0.6rem; display: block; font-size: 0.95rem; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 0.9rem 1.2rem; border: 2px solid #f0f0f0; border-radius: 14px; font-size: 1rem; font-family: 'Outfit', sans-serif; background: #fcfcfc; transition: var(--transition); }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: var(--primary); background: white; box-shadow: 0 0 0 4px rgba(128, 0, 0, 0.05); outline: none; }
        .photo-upload-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
        .photo-slot { position: relative; aspect-ratio: 4/5; background: #f8f8f8; border: 2px dashed #e0e0e0; border-radius: 20px; overflow: hidden; display: flex; flex-direction: column; align-items: center; justify-content: center; transition: var(--transition); }
        .photo-slot:hover { border-color: var(--primary); background: #fffafa; }
        .photo-preview { width: 100%; height: 100%; background-size: cover; background-position: center; }
        /* Cleaned up photo-remove styles as we're using inline for guaranteed mobile sizing */
        .photo-remove-wrapper { transition: var(--transition); }
        .photo-remove-wrapper:hover { transform: scale(1.1); }
        .btn-premium { 
            background: #800000; /* Fallback */
            background: var(--primary-gradient); 
            color: #ffffff !important; 
            padding: 1rem 2.5rem; 
            border-radius: 50px; 
            font-weight: 700; 
            border: none; 
            cursor: pointer; 
            font-size: 1.1rem; 
            display: inline-flex; 
            align-items: center; 
            gap: 10px; 
            box-shadow: 0 8px 20px rgba(128, 0, 0, 0.2); 
            transition: var(--transition); 
            text-decoration: none;
        }
        .btn-premium:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 12px 25px rgba(128, 0, 0, 0.3); 
            color: #ffffff !important;
        }
        .about-me-cta { background: linear-gradient(135deg, #fffaf5 0%, #fff0f0 100%); padding: 3rem; border-radius: 24px; text-align: center; border: 1px solid #fee; margin-top: 2rem; }
        .about-me-cta h3 { font-family: 'Playfair Display', serif; color: var(--primary); font-size: 1.8rem; margin-bottom: 0.8rem; }
        .about-me-cta p { color: #777; margin-bottom: 2rem; font-size: 1.05rem; }
        .notification { position: fixed; top: 20px; right: 20px; z-index: 10000; padding: 1rem 2rem; border-radius: 15px; background: #28a745; color: white; box-shadow: 0 10px 30px rgba(40, 167, 69, 0.3); display: none; animation: slideIn 0.5s forwards; }
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    </style>
@endsection

@section('content')
    <div class="profile-container">
        <div class="profile-header">
            <h1>Your Profile</h1>
            <p>Elevate your matchmaking experience with a complete and beautiful profile.</p>
        </div>

        <div style="max-width: 900px; margin: 0 auto;">
            @if(session('success'))
                <div class="notification success" style="display: block;">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Photos Card -->
                <div class="edit-section-card">
                    <div class="section-title">
                        <i class="fas fa-images"></i>
                        Profile Gallery
                    </div>
                    <div class="photo-upload-grid">
                        @for($i=1; $i<=3; $i++)
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                                <div class="photo-slot" id="photo-slot-{{ $i }}" style="margin: 0; width: 100%;">
                                    @php $photoField = "photo$i"; @endphp
                                    <div id="preview-{{ $i }}" class="photo-preview" style="{{ $profile->$photoField ? "background-image: url('" . asset('storage/' . $profile->$photoField) . "')" : 'display: none;' }}"></div>
                                    
                                    <div id="placeholder-{{ $i }}" style="text-align: center; padding: 1rem; {{ $profile->$photoField ? 'display: none;' : '' }}">
                                        <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: #ccc; margin-bottom: 0.5rem; display: block;"></i>
                                        <span style="font-size: 0.8rem; color: #999;">Photo {{ $i }}</span>
                                    </div>
                                    <input type="file" name="photo{{ $i }}" onchange="previewImage(this, {{ $i }})" accept="image/*" style="position: absolute; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 2;">
                                </div>
                                
                                @if($profile->$photoField)
                                    <div onclick="confirmDeletePhoto({{ $i }})" style="color: #dc3545; font-size: 0.75rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 5px; padding: 5px 12px; background: #fff5f5; border-radius: 50px; border: 1px solid rgba(220,53,69,0.1); transition: 0.3s;">
                                        <i class="fas fa-trash-alt" style="font-size: 0.7rem;"></i> Remove
                                    </div>
                                @else
                                    <div style="height: 28px;"></div> <!-- Spacer to keep alignment -->
                                @endif
                            </div>
                        @endfor
                    </div>
                    <p style="font-size: 0.8rem; color: #999; margin-top: 1.5rem; text-align: center;">Tip: Clear portraits work best for matchmaking.</p>
                </div>

                <!-- Identity Card -->
                <div class="edit-section-card">
                    <div class="section-title">
                        <i class="fas fa-id-card"></i>
                        Basic Identity
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name') <span style="color: #dc3545; font-size: 0.8rem;">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male" {{ old('gender', $profile->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender', $profile->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender') <span style="color: #dc3545; font-size: 0.8rem;">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="dob">Date of Birth</label>
                            <input type="date" name="dob" value="{{ old('dob', $profile->dob ? \Carbon\Carbon::parse($profile->dob)->format('Y-m-d') : '') }}" required>
                            @error('dob') <span style="color: #dc3545; font-size: 0.8rem;">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="marital_status">Marital Status</label>
                            <select name="marital_status" required>
                                <option value="">Select Status</option>
                                <option value="Never Married" {{ old('marital_status', $profile->marital_status) == 'Never Married' ? 'selected' : '' }}>Never Married</option>
                                <option value="Divorced" {{ old('marital_status', $profile->marital_status) == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                <option value="Widowed" {{ old('marital_status', $profile->marital_status) == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                            </select>
                            @error('marital_status') <span style="color: #dc3545; font-size: 0.8rem;">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="height">Height (e.g. 5'7")</label>
                            <input type="text" name="height" value="{{ old('height', $profile->height) }}" required>
                            @error('height') <span style="color: #dc3545; font-size: 0.8rem;">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Phone Number</label>
                            <input type="text" name="phone_number" value="{{ old('phone_number', $profile->phone_number) }}" placeholder="+91 XXXX XXXX" required>
                            @error('phone_number') <span style="color: #dc3545; font-size: 0.8rem;">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Identity Verification Card -->
                @if(Auth::user()->is_premium)
                    <div class="edit-section-card" style="border: 1px solid rgba(212, 175, 55, 0.5); background: #fffdf5;">
                        <div class="section-title">
                            <i class="fas fa-user-shield" style="background: #fff8e1; color: #D4AF37;"></i>
                            Identity Verification
                        </div>
                        <p style="color: #666; font-size: 0.95rem; margin-bottom: 2rem;">
                            Upload your Aadhaar Card to get the <strong>Verified Badge</strong>. Our team will manually review your document to ensure authenticity.
                        </p>
                        
                        <div class="form-grid">
                            <div class="form-group" style="grid-column: 1 / -1;">
                                <label for="aadhaar_card">Aadhaar Card (Clear Photo)</label>
                                <div style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
                                    <div style="flex: 1; min-width: 250px;">
                                        <input type="file" name="aadhaar_card" accept="image/*" onchange="previewAadhaar(this)" style="background: white;">
                                    </div>
                                    <div id="aadhaar-preview-container" style="{{ $profile->aadhaar_card ? '' : 'display: none;' }}">
                                        <img id="aadhaar-preview" src="{{ $profile->aadhaar_card ? asset('storage/' . $profile->aadhaar_card) : '#' }}" style="height: 120px; border-radius: 12px; border: 2px solid #D4AF37; box-shadow: 0 5px 15px rgba(212, 175, 55, 0.1);">
                                    </div>
                                </div>
                                @if($profile->verification_status)
                                    <div style="margin-top: 1.5rem;">
                                        <div class="status-chip status-{{ $profile->verification_status }}" style="padding: 8px 20px; font-size: 0.9rem;">
                                            <i class="fas {{ $profile->verification_status == 'approved' ? 'fa-check-circle' : ($profile->verification_status == 'rejected' ? 'fa-times-circle' : 'fa-clock') }}"></i>
                                            Verification {{ ucfirst($profile->verification_status) }}
                                        </div>
                                        @if($profile->verification_status == 'pending')
                                            <p style="font-size: 0.8rem; color: #888; margin-top: 0.5rem; margin-left: 5px;">Your document is under review. Usually takes 24-48 hours.</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div class="edit-section-card" style="border: 2px dashed #e0e0e0; background: #fcfcfc; position: relative;">
                        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.4); backdrop-filter: blur(2px); z-index: 1; border-radius: 24px;"></div>
                        <div class="section-title" style="color: #999; position: relative; z-index: 2;">
                            <i class="fas fa-lock" style="background: #eee; color: #999;"></i>
                            Identity Verification
                        </div>
                        <div style="text-align: center; padding: 2rem 1rem; position: relative; z-index: 2;">
                            <div style="width: 60px; height: 60px; background: #fff8e1; color: #D4AF37; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 1.5rem; box-shadow: 0 5px 15px rgba(212, 175, 55, 0.2);">
                                <i class="fas fa-crown"></i>
                            </div>
                            <h4 style="color: #333; margin-bottom: 0.5rem; font-size: 1.2rem;">Premium Feature</h4>
                            <p style="color: #666; margin-bottom: 2rem; max-width: 400px; margin-left: auto; margin-right: auto;">Unlock the <strong>Verified Badge</strong> by upgrading your plan. Verified users get 5x more attention!</p>
                            <a href="{{ route('plans') }}" class="btn-premium" style="padding: 0.8rem 2rem; font-size: 0.95rem;">
                                <i class="fas fa-arrow-up"></i> Upgrade to Verify
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Professional Card -->
                <div class="edit-section-card">
                    <div class="section-title">
                        <i class="fas fa-briefcase"></i>
                        Education & Profession
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="education">Highest Education</label>
                            <input type="text" name="education" value="{{ old('education', $profile->education) }}" required>
                            @error('education') <span style="color: #dc3545; font-size: 0.8rem;">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="occupation">Current Occupation</label>
                            <input type="text" name="occupation" value="{{ old('occupation', $profile->occupation) }}" required>
                            @error('occupation') <span style="color: #dc3545; font-size: 0.8rem;">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="annual_income">Annual Income</label>
                            <input type="text" name="annual_income" value="{{ old('annual_income', $profile->annual_income) }}" required>
                            @error('annual_income') <span style="color: #dc3545; font-size: 0.8rem;">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="city">Current City</label>
                            <input type="text" name="city" value="{{ old('city', $profile->city) }}" required>
                            @error('city') <span style="color: #dc3545; font-size: 0.8rem;">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label for="state">State</label>
                            <select name="state" required>
                                <option value="">Select State</option>
                                @php
                                    $states = ['Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chhattisgarh', 'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh', 'Jharkhand', 'Karnataka', 'Kerala', 'Madhya Pradesh', 'Maharashtra', 'Manipur', 'Meghalaya', 'Mizoram', 'Nagaland', 'Odisha', 'Punjab', 'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana', 'Tripura', 'Uttar Pradesh', 'Uttarakhand', 'West Bengal', 'Andaman and Nicobar Islands', 'Chandigarh', 'Dadra and Nagar Haveli and Daman and Diu', 'Lakshadweep', 'Delhi', 'Puducherry', 'Ladakh', 'Jammu and Kashmir'];
                                @endphp
                                @foreach($states as $state)
                                    <option value="{{ $state }}" {{ old('state', $profile->state) == $state ? 'selected' : '' }}>{{ $state }}</option>
                                @endforeach
                            </select>
                            @error('state') <span style="color: #dc3545; font-size: 0.8rem;">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- CTA Section -->
                <div class="about-me-cta">
                    <h3>Personality & Interests</h3>
                    <p>Go beyond the basics. Share your lifestyle, family values, and what makes you unique.</p>
                    <a href="{{ route('profile.about') }}" class="btn-premium" style="text-decoration: none;">
                        <i class="fas fa-magic"></i> Enhance Your Story
                    </a>
                </div>

                <div style="text-align: center; margin-top: 4rem;">
                    <button type="submit" class="btn-premium"><i class="fas fa-check-circle"></i> Update Basic Profile</button>
                </div>
            </form>

            <div style="margin-top: 6rem; padding: 3rem; background: #fff5f5; border-radius: 24px; text-align: center; border: 1px solid #fee;">
                <h3 style="color: #dc3545; font-family: 'Playfair Display', serif; font-size: 1.5rem; margin-bottom: 1rem;">Account Management</h3>
                <p style="color: #888; font-size: 1rem; margin-bottom: 2rem;">Thinking of leaving? You can deactivate your account here. We'll miss you!</p>
                <button type="button" onclick="showDeleteModal()" style="background: white; border: 2px solid #dc3545; color: #dc3545; padding: 0.8rem 2.5rem; border-radius: 50px; cursor: pointer; font-weight: 600; transition: var(--transition);">
                    <i class="fas fa-trash-alt"></i> Delete My Account
                </button>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <div id="delete-modal" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 10000; align-items: center; justify-content: center; backdrop-filter: blur(5px);">
        <div class="modal-content" style="background: white; padding: 3rem; border-radius: 30px; width: 90%; max-width: 500px; text-align: center; box-shadow: 0 25px 50px rgba(0,0,0,0.2);">
            <div id="delete-step-1">
                <div style="width: 80px; height: 80px; background: #fff5f5; color: #dc3545; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 0 auto 2rem;">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h2 style="color: #333; font-family: 'Playfair Display', serif; margin-bottom: 1.5rem;">Delete Account?</h2>
                <div style="background: #fdfdfd; padding: 1.5rem; border-radius: 20px; border: 1px solid #eee; text-align: left; margin-bottom: 2rem;">
                    <p style="font-weight: 600; color: #dc3545; margin-bottom: 1rem;">This will result in:</p>
                    <ul style="color: #666; font-size: 0.95rem; line-height: 1.6;">
                        <li>Hiding your profile from matches</li>
                        <li>Loss of all interests and likes</li>
                        <li>24-hour window for recovery</li>
                    </ul>
                </div>
                <div style="display: flex; gap: 1rem;">
                    <button onclick="closeDeleteModal()" style="flex: 1; padding: 1rem; border: none; border-radius: 15px; background: #f0f0f0; cursor: pointer; font-weight: 600;">Cancel</button>
                    <button onclick="requestDeletionOtp()" id="send-delete-otp-btn" style="flex: 1; padding: 1rem; border: none; border-radius: 15px; background: #dc3545; color: white; cursor: pointer; font-weight: 600;">Send OTP</button>
                </div>
            </div>

            <div id="delete-step-2" style="display: none;">
                <h2 style="color: #333; font-family: 'Playfair Display', serif; margin-bottom: 1rem;">Verify Deletion</h2>
                <input type="text" id="deletion-otp" placeholder="000000" style="width: 100%; padding: 1rem; border: 2px solid #eee; border-radius: 15px; text-align: center; font-size: 2rem; letter-spacing: 10px; margin-bottom: 2rem;">
                <div style="display: flex; gap: 1rem;">
                    <button onclick="closeDeleteModal()" style="flex: 1; padding: 1rem; border: none; border-radius: 15px; background: #f0f0f0; cursor: pointer;">Cancel</button>
                    <button onclick="confirmDeletion()" id="confirm-delete-btn" style="flex: 1; padding: 1rem; border: none; border-radius: 15px; background: #dc3545; color: white; cursor: pointer; font-weight: bold;">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <form id="delete-photo-form" action="" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@section('scripts')
    <script>
        function previewImage(input, index) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    let preview = document.getElementById(`preview-${index}`);
                    const placeholder = document.getElementById(`placeholder-${index}`);
                    
                    if (!preview) {
                        preview = document.createElement('div');
                        preview.id = `preview-${index}`;
                        preview.className = 'photo-preview';
                        document.getElementById(`photo-slot-${index}`).prepend(preview);
                    }
                    
                    preview.style.backgroundImage = `url('${e.target.result}')`;
                    preview.style.display = 'block';
                    if (placeholder) placeholder.style.display = 'none';
                    document.getElementById(`photo-slot-${index}`).style.borderColor = '#28a745';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewAadhaar(input) {
            const container = document.getElementById('aadhaar-preview-container');
            const preview = document.getElementById('aadhaar-preview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    container.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function confirmDeletePhoto(index) {
            if (confirm('Are you sure you want to remove this photo?')) {
                const form = document.getElementById('delete-photo-form');
                form.action = `/profile/photo/${index}`;
                form.submit();
            }
        }

        function showDeleteModal() { document.getElementById('delete-modal').style.display = 'flex'; }
        function closeDeleteModal() { document.getElementById('delete-modal').style.display = 'none'; }

        async function requestDeletionOtp() {
            const btn = document.getElementById('send-delete-otp-btn');
            btn.disabled = true;
            btn.innerText = 'Sending...';

            try {
                const response = await fetch('/profile/delete-request', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                const data = await response.json();
                if (data.success) {
                    document.getElementById('delete-step-1').style.display = 'none';
                    document.getElementById('delete-step-2').style.display = 'block';
                } else {
                    alert(data.message);
                }
            } catch (error) {
                alert('Something went wrong. Please try again.');
            } finally {
                btn.disabled = false;
                btn.innerText = 'Send OTP';
            }
        }

        async function confirmDeletion() {
            const otp = document.getElementById('deletion-otp').value;
            if (!otp) return alert('Please enter the OTP.');

            const btn = document.getElementById('confirm-delete-btn');
            btn.disabled = true;
            btn.innerText = 'Deleting...';

            try {
                const response = await fetch('/profile/delete-confirm', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ otp })
                });
                const data = await response.json();
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    alert(data.message);
                }
            } catch (error) {
                alert('Something went wrong. Please try again.');
            } finally {
                btn.disabled = false;
                btn.innerText = 'Confirm Delete';
            }
        }
    </script>
@endsection
