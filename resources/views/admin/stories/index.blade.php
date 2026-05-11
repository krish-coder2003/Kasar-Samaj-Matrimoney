@extends('layouts.admin')

@section('title', 'Manage Success Stories')

@section('styles')
<style>
    .story-card {
        padding: 1.5rem;
        border: 1px solid #f0f0f0;
        border-radius: 15px;
        margin-bottom: 1.5rem;
        background: #fff;
        transition: 0.3s;
    }
    .story-card:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
    
    table { width: 100%; border-collapse: collapse; }
    th, td { text-align: left; padding: 1.2rem 1rem; border-bottom: 1px solid #f0f0f0; }
    th { color: #888; text-transform: uppercase; font-size: 0.75rem; font-weight: 700; letter-spacing: 1px; }

    .story-photo { width: 80px; height: 55px; object-fit: cover; border-radius: 10px; border: 2px solid #eee; }
    .btn-delete-story { background: rgba(255, 71, 87, 0.1); color: #ff4757; border: 1px solid rgba(255, 71, 87, 0.2); padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: 700; cursor: pointer; transition: 0.3s; }
    .btn-delete-story:hover { background: #ff4757; color: white; }
</style>
@endsection

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem; flex-wrap: wrap; gap: 1.5rem;">
        <div>
            <h1 style="font-size: 2.5rem; color: #333; margin: 0 0 0.5rem;">Success Stories</h1>
            <p style="color: #888; font-size: 1.1rem; margin: 0;">Manage the beautiful stories of our matched couples</p>
        </div>
        <a href="{{ route('admin.stories.create') }}" class="btn-primary-admin">
            <i class="fas fa-plus"></i> Add New Story
        </a>
    </div>

    @if(session('success'))
        <div class="admin-card" style="background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; padding: 1rem 2rem; margin-bottom: 2rem;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="admin-card" style="padding: 1.5rem;">
        <div class="desktop-only">
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Couple Name</th>
                            <th>Story Preview</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stories as $story)
                        <tr>
                            <td>
                                @if($story->photo)
                                    <img src="{{ asset('storage/' . $story->photo) }}" class="story-photo">
                                @else
                                    <div style="width: 80px; height: 55px; background: #f5f5f5; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #ccc;"><i class="fas fa-image"></i></div>
                                @endif
                            </td>
                            <td style="font-weight: 700; color: #333; font-size: 1.1rem;">{{ $story->couple_name }}</td>
                            <td style="color: #666; max-width: 400px; font-size: 0.95rem; line-height: 1.5;">{{ Str::limit($story->story, 120) }}</td>
                            <td style="text-align: right;">
                                <form action="{{ route('admin.stories.delete', $story) }}" method="POST" onsubmit="return confirm('Delete this story?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-delete-story">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: #888; padding: 5rem;">
                                <i class="fas fa-heart" style="font-size: 4rem; display: block; opacity: 0.05; color: #800000; margin-bottom: 1.5rem;"></i>
                                No success stories added yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mobile-only">
            @forelse($stories as $story)
                <div class="story-card">
                    <div style="display: flex; gap: 15px; align-items: center; margin-bottom: 1.2rem;">
                        @if($story->photo)
                            <img src="{{ asset('storage/' . $story->photo) }}" style="width: 100px; height: 70px; object-fit: cover; border-radius: 12px;">
                        @else
                            <div style="width: 100px; height: 70px; background: #f5f5f5; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #ccc;"><i class="fas fa-image"></i></div>
                        @endif
                        <h3 style="margin: 0; color: #333; font-weight: 800; font-size: 1.2rem;">{{ $story->couple_name }}</h3>
                    </div>
                    <div style="color: #666; font-size: 1rem; line-height: 1.6; margin-bottom: 1.5rem;">
                        {{ $story->story }}
                    </div>
                    <form action="{{ route('admin.stories.delete', $story) }}" method="POST" onsubmit="return confirm('Delete this story?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-delete-story" style="width: 100%; padding: 1rem;">Delete Story</button>
                    </form>
                </div>
            @empty
                <p style="text-align: center; color: #888; padding: 4rem;">No success stories added yet.</p>
            @endforelse
        </div>
    </div>
@endsection
