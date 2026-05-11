@extends('layouts.admin')

@section('title', 'Site Settings')

@section('styles')
<style>
    .form-group { margin-bottom: 2rem; }
    .form-group label { display: block; margin-bottom: 0.8rem; font-weight: 700; color: #800000; font-size: 1.1rem; }
    .form-group input[type="text"], 
    .form-group input[type="email"], 
    .form-group textarea { 
        width: 100%; 
        padding: 1.1rem; 
        border: 2px solid #f0f0f0; 
        border-radius: 12px; 
        font-family: inherit; 
        transition: 0.3s;
        background: #fdfdfd;
    }
    .form-group input:focus, 
    .form-group textarea:focus { 
        border-color: #800000; 
        outline: none; 
        background: #fff;
        box-shadow: 0 5px 15px rgba(128,0,0,0.05);
    }
    
    .settings-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; }
    
    .file-upload-card {
        border: 2px dashed #ddd;
        padding: 2rem;
        border-radius: 15px;
        text-align: center;
        background: #fafafa;
        transition: 0.3s;
    }
    .file-upload-card:hover { border-color: #800000; background: #fff; }

    .developer-info {
        background: #fdfdfd;
        padding: 2.5rem;
        border-radius: 20px;
        border: 1px solid #f0f0f0;
        margin-top: 2.5rem;
        box-shadow: inset 0 2px 10px rgba(0,0,0,0.02);
    }
    .developer-info h4 { 
        margin: 0 0 1.8rem; 
        color: #333; 
        font-size: 1.2rem; 
        display: flex; 
        align-items: center; 
        gap: 12px;
        font-weight: 800;
    }
    .developer-info .form-group label { 
        font-size: 0.85rem; 
        color: #888; 
        margin-bottom: 0.6rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
</style>
@endsection

@section('content')
    <div style="margin-bottom: 3rem;">
        <h1 style="font-size: 2.5rem; color: #333; margin: 0 0 0.5rem;">Site Customization</h1>
        <p style="color: #888; font-size: 1.1rem; margin: 0;">Manage content, stories and global visual elements</p>
    </div>

    @if(session('success'))
        <div class="admin-card" style="background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; padding: 1rem 2rem; margin-bottom: 2rem;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="admin-card">
            <h3 style="margin: 0 0 1.5rem; font-size: 1.3rem;"><i class="fas fa-chart-line"></i> Website Statistics</h3>
            <div class="settings-grid">
                <div class="form-group">
                    <label>Active Profiles</label>
                    <input type="text" name="stat_active_profiles" value="{{ \App\Models\Setting::get('stat_active_profiles') }}" placeholder="e.g. 10,000+">
                </div>
                <div class="form-group">
                    <label>Success Stories</label>
                    <input type="text" name="stat_success_stories" value="{{ \App\Models\Setting::get('stat_success_stories') }}" placeholder="e.g. 5,000+">
                </div>
                <div class="form-group">
                    <label>Verified Profiles</label>
                    <input type="text" name="stat_verified_profiles" value="{{ \App\Models\Setting::get('stat_verified_profiles') }}" placeholder="e.g. 100%">
                </div>
            </div>
        </div>

        <div class="admin-card">
            <h3 style="margin: 0 0 1.5rem; font-size: 1.3rem;"><i class="fas fa-image"></i> Visual Settings</h3>
            <div class="form-group">
                <label>Website Hero Background Image</label>
                <div class="file-upload-card" onclick="document.getElementById('hero_image').click()">
                    <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: #ccc; margin-bottom: 1rem; display: block;"></i>
                    <span style="font-weight: 600; color: #666;">Click to upload new hero image</span>
                    <input type="file" id="hero_image" name="hero_image" accept="image/*" style="display: none;">
                </div>
                @if($currentHero = \App\Models\Setting::get('hero_image'))
                    <div style="margin-top: 1.5rem; display: flex; align-items: center; gap: 15px;">
                        <img src="{{ asset('storage/' . $currentHero) }}" style="width: 120px; height: 70px; object-fit: cover; border-radius: 10px; border: 2px solid #eee;">
                        <span style="font-size: 0.9rem; color: #888;">Current active hero image</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="admin-card">
            <h3 style="margin: 0 0 1.5rem; font-size: 1.3rem;"><i class="fas fa-star"></i> Why Choose Us Section</h3>
            <div class="settings-grid">
                @for($i=1; $i<=3; $i++)
                <div style="border: 1px solid #f0f0f0; padding: 1.5rem; border-radius: 15px; background: #fafafa;">
                    <h4 style="margin: 0 0 1rem; color: #800000;">Card {{ $i }}</h4>
                    <div class="form-group">
                        <label style="font-size: 0.9rem;">Title</label>
                        <input type="text" name="wcu_title_{{ $i }}" value="{{ \App\Models\Setting::get('wcu_title_'.$i) }}">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="font-size: 0.9rem;">Description</label>
                        <textarea name="wcu_desc_{{ $i }}" style="min-height: 100px;">{{ \App\Models\Setting::get('wcu_desc_'.$i) }}</textarea>
                    </div>
                </div>
                @endfor
            </div>
        </div>

        <div class="admin-card">
            <h3 style="margin: 0 0 1.5rem; font-size: 1.3rem;"><i class="fas fa-info-circle"></i> Footer Information</h3>
            <div class="form-group">
                <label>About Us Text (Footer)</label>
                <textarea name="footer_about_text" style="min-height: 120px;">{{ \App\Models\Setting::get('footer_about_text') }}</textarea>
            </div>
            <div class="settings-grid">
                <div class="form-group">
                    <label>Support Email</label>
                    <input type="email" name="footer_contact_email" value="{{ \App\Models\Setting::get('footer_contact_email') }}">
                </div>
                <div class="form-group">
                    <label>Support Phone</label>
                    <input type="text" name="footer_contact_phone" value="{{ \App\Models\Setting::get('footer_contact_phone') }}">
                </div>
                <div class="form-group">
                    <label>Office Address</label>
                    <input type="text" name="footer_contact_address" value="{{ \App\Models\Setting::get('footer_contact_address') }}">
                </div>
            </div>

            <div class="developer-info">
                <h4><i class="fas fa-code"></i> Developer Credit Information</h4>
                <div class="settings-grid">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="developer_name" value="{{ \App\Models\Setting::get('developer_name') ?: 'Krishna Shrangare' }}">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="developer_email" value="{{ \App\Models\Setting::get('developer_email') ?: 'krishnashrangare@gmail.com' }}">
                    </div>
                    <div class="form-group">
                        <label>Mobile</label>
                        <input type="text" name="developer_phone" value="{{ \App\Models\Setting::get('developer_phone') ?: '8767496609' }}">
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top: 3rem; margin-bottom: 5rem;">
            <button type="submit" class="btn-primary-admin" style="width: 100%; justify-content: center; padding: 1.5rem; font-size: 1.2rem; border-radius: 15px; box-shadow: 0 10px 30px rgba(128,0,0,0.3);">
                <i class="fas fa-save"></i> Save Global Settings
            </button>
        </div>
    </form>
@endsection
