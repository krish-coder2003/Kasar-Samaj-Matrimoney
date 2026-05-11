@if(Auth::check() && Auth::user()->isPendingDeletion())
    <div style="background: #fff3cd; color: #856404; padding: 1rem; text-align: center; border-bottom: 1px solid #ffeeba; position: relative; z-index: 10001; margin-top: 0;">
        <i class="fas fa-exclamation-triangle"></i> 
        Your account is scheduled for deletion on <strong>{{ Auth::user()->getDeletionRecoveryTime()->format('M d, Y h:i A') }}</strong>. 
        <form action="{{ route('profile.recover') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" style="background: var(--primary); color: white; border: none; padding: 0.3rem 1rem; border-radius: 5px; margin-left: 1rem; cursor: pointer; font-weight: bold;">Recover Account</button>
        </form>
    </div>
@endif
