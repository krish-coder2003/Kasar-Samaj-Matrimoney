@extends('layouts.admin')

@section('title', 'Legal & Content Pages')

@section('styles')
<style>
    .form-group { margin-bottom: 2rem; }
    .form-group label { display: flex; align-items: center; gap: 10px; margin-bottom: 0.8rem; font-weight: 700; color: #800000; font-size: 1.1rem; }
    .form-group textarea { 
        width: 100%; 
        min-height: 350px; 
        padding: 1.5rem; 
        border: 2px solid #f0f0f0; 
        border-radius: 15px; 
        font-family: inherit; 
        font-size: 1rem;
        line-height: 1.7;
        transition: 0.3s;
        background: #fdfdfd;
    }
    .form-group textarea:focus {
        border-color: #800000;
        outline: none;
        background: #fff;
        box-shadow: 0 10px 25px rgba(128,0,0,0.05);
    }
    
    .tabs {
        display: flex;
        gap: 0.8rem;
        margin-bottom: 2rem;
        overflow-x: auto;
        padding-bottom: 10px;
        scrollbar-width: none;
    }
    .tabs::-webkit-scrollbar { display: none; }
    
    .tab-btn {
        padding: 0.8rem 1.8rem;
        background: white;
        border: 1px solid #eee;
        border-radius: 12px;
        cursor: pointer;
        white-space: nowrap;
        transition: 0.3s;
        font-weight: 700;
        color: #666;
        font-size: 0.9rem;
    }
    .tab-btn.active {
        background: #800000;
        color: white;
        border-color: #800000;
        box-shadow: 0 5px 15px rgba(128,0,0,0.2);
    }
    .tab-btn:hover:not(.active) { background: #f5f5f5; border-color: #ddd; }
    
    .sticky-save {
        position: sticky;
        bottom: 2rem;
        display: flex;
        justify-content: flex-end;
        z-index: 100;
    }
</style>
@endsection

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 3rem; gap: 2rem; flex-wrap: wrap;">
        <div>
            <h1 style="font-size: 2.5rem; color: #333; margin: 0 0 0.5rem;">Legal & Content Pages</h1>
            <p style="color: #888; font-size: 1.1rem; margin: 0;">Manage your platform's policies, terms, and support documentation</p>
        </div>
        <a href="{{ route('home') }}" target="_blank" class="btn-primary-admin" style="background: #333;">
            <i class="fas fa-external-link-alt"></i> View Live Site
        </a>
    </div>

    @if(session('success'))
        <div class="admin-card" style="background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; padding: 1rem 2rem; margin-bottom: 2rem;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="tabs">
        <button class="tab-btn active" onclick="showTab('privacy')"><i class="fas fa-user-shield"></i> Privacy Policy</button>
        <button class="tab-btn" onclick="showTab('terms')"><i class="fas fa-file-contract"></i> Terms of Use</button>
        <button class="tab-btn" onclick="showTab('cookie')"><i class="fas fa-cookie-bite"></i> Cookie Policy</button>
        <button class="tab-btn" onclick="showTab('safety')"><i class="fas fa-shield-alt"></i> Safety Tips</button>
        <button class="tab-btn" onclick="showTab('help')"><i class="fas fa-question-circle"></i> Help Center</button>
        <button class="tab-btn" onclick="showTab('refund')"><i class="fas fa-undo"></i> Refund Policy</button>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        
        <div id="tab-privacy" class="tab-content">
            <div class="admin-card">
                <div class="form-group">
                    <label><i class="fas fa-user-shield"></i> Privacy Policy</label>
                    <textarea name="privacy-policy">{{ \App\Models\Setting::get('privacy-policy') }}</textarea>
                    <div style="margin-top: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 10px; font-size: 0.85rem; color: #888;">
                        <i class="fas fa-link"></i> This content is displayed at: <strong style="color: #555;">{{ url('/p/privacy-policy') }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div id="tab-terms" class="tab-content" style="display: none;">
            <div class="admin-card">
                <div class="form-group">
                    <label><i class="fas fa-file-contract"></i> Terms of Use</label>
                    <textarea name="terms-of-use">{{ \App\Models\Setting::get('terms-of-use') }}</textarea>
                    <div style="margin-top: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 10px; font-size: 0.85rem; color: #888;">
                        <i class="fas fa-link"></i> This content is displayed at: <strong style="color: #555;">{{ url('/p/terms-of-use') }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div id="tab-cookie" class="tab-content" style="display: none;">
            <div class="admin-card">
                <div class="form-group">
                    <label><i class="fas fa-cookie-bite"></i> Cookie Policy</label>
                    <textarea name="cookie-policy">{{ \App\Models\Setting::get('cookie-policy') }}</textarea>
                    <div style="margin-top: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 10px; font-size: 0.85rem; color: #888;">
                        <i class="fas fa-link"></i> This content is displayed at: <strong style="color: #555;">{{ url('/p/cookie-policy') }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div id="tab-safety" class="tab-content" style="display: none;">
            <div class="admin-card">
                <div class="form-group">
                    <label><i class="fas fa-shield-alt"></i> Safety Tips</label>
                    <textarea name="safety-tips">{{ \App\Models\Setting::get('safety-tips') }}</textarea>
                    <div style="margin-top: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 10px; font-size: 0.85rem; color: #888;">
                        <i class="fas fa-link"></i> This content is displayed at: <strong style="color: #555;">{{ url('/p/safety-tips') }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div id="tab-help" class="tab-content" style="display: none;">
            <div class="admin-card">
                <div class="form-group">
                    <label><i class="fas fa-question-circle"></i> Help Center Content</label>
                    <textarea name="help-center">{{ \App\Models\Setting::get('help-center') }}</textarea>
                    <div style="margin-top: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 10px; font-size: 0.85rem; color: #888;">
                        <i class="fas fa-link"></i> This appears at the top of the Help Center page: <strong style="color: #555;">{{ url('/p/help-center') }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div id="tab-refund" class="tab-content" style="display: none;">
            <div class="admin-card">
                <div class="form-group">
                    <label><i class="fas fa-undo"></i> Refund Policy</label>
                    <textarea name="refund-policy">{{ \App\Models\Setting::get('refund-policy') }}</textarea>
                    <div style="margin-top: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 10px; font-size: 0.85rem; color: #888;">
                        <i class="fas fa-link"></i> This content is displayed at: <strong style="color: #555;">{{ url('/p/refund-policy') }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="sticky-save">
            <button type="submit" class="btn-primary-admin" style="padding: 1.2rem 3rem; font-size: 1.1rem; box-shadow: 0 10px 25px rgba(128, 0, 0, 0.3);">
                <i class="fas fa-save"></i> Save All Changes
            </button>
        </div>
    </form>
@endsection

@section('scripts')
<script>
    function showTab(tab) {
        document.querySelectorAll('.tab-content').forEach(c => c.style.display = 'none');
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        
        document.getElementById('tab-' + tab).style.display = 'block';
        event.currentTarget.classList.add('active');
        
        // Scroll to top of content
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>
@endsection
