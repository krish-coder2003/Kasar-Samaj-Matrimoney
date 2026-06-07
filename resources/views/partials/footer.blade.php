<div id="notification" class="notification"></div>

<footer>
    <div class="footer-grid">
        <div class="footer-col">
            <h4 style="display: flex; align-items: center; gap: 12px; margin-bottom: 2rem;">
                <img src="/images/logo-icon.png" alt="Logo" style="height: 45px; width: 45px; border-radius: 50%; border: 2px solid var(--secondary); box-shadow: 0 0 20px rgba(212, 175, 55, 0.2);">
                Kasar Community
            </h4>
            <p>{{ \App\Models\Setting::get('footer_about_text') }}</p>
        </div>
        
        <div class="footer-col">
            <h4>Quick Links</h4>
            <ul>
                @guest
                    <li><a href="{{ route('home') }}#stories"><i class="fas fa-chevron-right" style="font-size: 0.7rem;"></i> Success Stories</a></li>
                @endguest
                <li><a href="{{ route('plans') }}"><i class="fas fa-chevron-right" style="font-size: 0.7rem;"></i> Premium Plans</a></li>
                <li><a href="{{ route('pages.show', 'help-center') }}"><i class="fas fa-chevron-right" style="font-size: 0.7rem;"></i> Help Center</a></li>
                @auth
                    <li><a href="{{ route('profile.edit') }}"><i class="fas fa-chevron-right" style="font-size: 0.7rem;"></i> My Profile</a></li>
                @endauth
            </ul>
        </div>

        <div class="footer-col">
            <h4>Support</h4>
            <ul>
                <li><a href="{{ route('pages.show', 'privacy-policy') }}"><i class="fas fa-shield-alt" style="font-size: 0.8rem;"></i> Privacy Policy</a></li>
                <li><a href="{{ route('pages.show', 'terms-of-use') }}"><i class="fas fa-file-contract" style="font-size: 0.8rem;"></i> Terms of Use</a></li>
                <li><a href="{{ route('pages.show', 'cookie-policy') }}"><i class="fas fa-cookie-bite" style="font-size: 0.8rem;"></i> Cookie Policy</a></li>
                <li><a href="{{ route('pages.show', 'safety-tips') }}"><i class="fas fa-user-shield" style="font-size: 0.8rem;"></i> Safety Tips</a></li>
                <li><a href="{{ route('pages.show', 'refund-policy') }}"><i class="fas fa-undo" style="font-size: 0.8rem;"></i> Refund Policy</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Get In Touch</h4>
            <a href="mailto:{{ \App\Models\Setting::get('footer_contact_email') }}" class="contact-item" style="text-decoration: none; display: flex; color: inherit;">
                <i class="fas fa-envelope"></i>
                <div>
                    <p style="margin: 0; font-size: 0.8rem; color: var(--secondary);">Email Us</p>
                    <p style="margin: 0; color: #fff;">{{ \App\Models\Setting::get('footer_contact_email') }}</p>
                </div>
            </a>
            <a href="tel:{{ \App\Models\Setting::get('footer_contact_phone') }}" class="contact-item" style="text-decoration: none; display: flex; color: inherit;">
                <i class="fas fa-phone-alt"></i>
                <div>
                    <p style="margin: 0; font-size: 0.8rem; color: var(--secondary);">Call Support</p>
                    <p style="margin: 0; color: #fff;">{{ \App\Models\Setting::get('footer_contact_phone') }}</p>
                </div>
            </a>
            
            @if($devName = \App\Models\Setting::get('developer_name'))
            <div class="dev-card">
                <p style="margin: 0; font-size: 0.75rem; color: var(--secondary); text-transform: uppercase; letter-spacing: 1px; font-weight: 700;">Crafted By</p>
                <p style="margin: 0.3rem 0; color: #fff; font-weight: 600;">{{ $devName }}</p>
                @if($devEmail = \App\Models\Setting::get('developer_email'))
                    <p style="margin: 0; font-size: 0.85rem; opacity: 0.6;"><i class="far fa-envelope"></i> {{ $devEmail }}</p>
                @endif
            </div>
            @endif
        </div>
    </div>
    
    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} Kasar Community Matrimony. @if($devName) Designed with <i class="fas fa-heart" style="color: var(--primary); font-size: 0.8rem;"></i> for the community. @endif All Rights Reserved.</p>
    </div>
</footer>
