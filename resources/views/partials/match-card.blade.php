<div class="match-card">
    @php
        $p = $match->profile;
        $photos = array_filter([$p->photo1, $p->photo2, $p->photo3]);
        $mainPhoto = !empty($photos) ? asset('storage/' . $photos[0]) : 'https://ui-avatars.com/api/?name=' . urlencode($match->name) . '&background=800000&color=fff&size=300';
    @endphp
    <div class="match-photo" id="main-photo-{{ $match->id }}" style="background-image: url('{{ $mainPhoto }}'); position: relative;">
        <div class="like-btn {{ in_array($match->id, $likedUserIds ?? []) ? 'active' : '' }}" onclick="window.toggleLike({{ $match->id }}, event)" id="like-{{ $match->id }}">
            <i class="{{ in_array($match->id, $likedUserIds ?? []) ? 'fas' : 'far' }} fa-heart"></i>
        </div>
    </div>
    
    @if(count($photos) > 1)
        <div class="photo-thumbnails">
            @foreach($photos as $photo)
                <div class="thumb" style="background-image: url('{{ asset('storage/' . $photo) }}');" onclick="changePhoto({{ $match->id }}, '{{ asset('storage/' . $photo) }}')"></div>
            @endforeach
        </div>
    @endif

    <div class="match-info">
        <h4>
            {{ $match->name }}
            @if($match->profile->is_verified)
                <span class="verified-badge {{ $match->is_premium ? 'gold' : '' }}" title="Verified Profile">
                    <i class="fas fa-check"></i>
                </span>
            @endif
        </h4>
        <div class="match-details">
            <span><i class="fas fa-birthday-cake"></i> Age: {{ \Carbon\Carbon::parse($match->profile->dob)->age ?? 'N/A' }} yrs</span>
            <span><i class="fas fa-graduation-cap"></i> Education: {{ $match->profile->education ?? 'N/A' }}</span>
            <span><i class="fas fa-briefcase"></i> Occupation: {{ $match->profile->occupation ?? 'N/A' }}</span>
            <span><i class="fas fa-map-marker-alt"></i> City: {{ $match->profile->city ?? 'N/A' }}, {{ $match->profile->state ?? 'N/A' }}</span>
        </div>
        <button class="btn-primary btn-block" style="padding: 0.5rem;" onclick="window.openDetailModal({{ json_encode($match) }}, {{ json_encode($photos) }}, {{ Auth::user()->is_premium ? 'true' : 'false' }}, {{ in_array($match->id, $sentInterestIds ?? []) ? 'true' : 'false' }})"><i class="fas fa-eye"></i> View Full Profile</button>
    </div>
</div>
