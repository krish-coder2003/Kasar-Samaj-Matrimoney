<div id="notification" class="notification"></div>

<footer>
    <div class="footer-grid">
        <div class="footer-col">
            <h4 class="footer-logo-title">
                <img src="/images/logo-icon.png" alt="Logo" class="footer-logo-img">
                Kasar Samaj
            </h4>
            <p>{{ \App\Models\Setting::get('footer_about_text') }}</p>
        </div>
        
        <div class="footer-col">
            <h4>Quick Links</h4>
            <ul>
                @guest
                    <li><a href="{{ route('home') }}#stories"><i class="fas fa-chevron-right"></i> Success Stories</a></li>
                @endguest
                <li><a href="{{ route('plans') }}"><i class="fas fa-chevron-right"></i> Premium Plans</a></li>
                <li><a href="{{ route('pages.show', 'help-center') }}"><i class="fas fa-chevron-right"></i> Help Center</a></li>
                @auth
                    <li><a href="{{ route('profile.edit') }}"><i class="fas fa-chevron-right"></i> My Profile</a></li>
                @endauth
            </ul>
        </div>

        <div class="footer-col">
            <h4>Support</h4>
            <ul>
                <li><a href="{{ route('pages.show', 'privacy-policy') }}"><i class="fas fa-shield-alt"></i> Privacy Policy</a></li>
                <li><a href="{{ route('pages.show', 'terms-of-use') }}"><i class="fas fa-file-contract"></i> Terms of Use</a></li>
                <li><a href="{{ route('pages.show', 'cookie-policy') }}"><i class="fas fa-cookie-bite"></i> Cookie Policy</a></li>
                <li><a href="{{ route('pages.show', 'safety-tips') }}"><i class="fas fa-user-shield"></i> Safety Tips</a></li>
                <li><a href="{{ route('pages.show', 'refund-policy') }}"><i class="fas fa-undo"></i> Refund Policy</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Get In Touch</h4>
            <a href="mailto:{{ \App\Models\Setting::get('footer_contact_email') }}" class="contact-item">
                <i class="fas fa-envelope"></i>
                <div class="contact-info">
                    <p class="contact-label">Email Us</p>
                    <p class="contact-value">{{ \App\Models\Setting::get('footer_contact_email') }}</p>
                </div>
            </a>
            <a href="tel:{{ \App\Models\Setting::get('footer_contact_phone') }}" class="contact-item">
                <i class="fas fa-phone-alt"></i>
                <div class="contact-info">
                    <p class="contact-label">Call Support</p>
                    <p class="contact-value">{{ \App\Models\Setting::get('footer_contact_phone') }}</p>
                </div>
            </a>
            
            @if($devName = \App\Models\Setting::get('developer_name'))
            <div class="dev-card">
                <p class="dev-label">Crafted By</p>
                <p class="dev-name">{{ $devName }}</p>
                @if($devEmail = \App\Models\Setting::get('developer_email'))
                    <p class="dev-email"><i class="far fa-envelope"></i> {{ $devEmail }}</p>
                @endif
            </div>
            @endif
        </div>
    </div>
    
    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} Kasar Samaj Matrimony. @if($devName) Designed with <i class="fas fa-heart" style="color: var(--primary); font-size: 0.8rem;"></i> for the community. @endif All Rights Reserved.</p>
    </div>
</footer>
