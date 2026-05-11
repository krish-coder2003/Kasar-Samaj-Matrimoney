@extends('layouts.admin')

@section('title', 'Add Success Story')

@section('styles')
<style>
    .form-group { margin-bottom: 2rem; }
    .form-group label { display: block; margin-bottom: 0.8rem; font-weight: 700; color: #333; font-size: 1rem; }
    .form-group input[type="text"], 
    .form-group textarea { 
        width: 100%; 
        padding: 1.2rem; 
        border: 2px solid #f0f0f0; 
        border-radius: 12px; 
        font-family: inherit; 
        font-size: 1rem;
        transition: 0.3s;
        background: #fdfdfd;
    }
    .form-group input:focus, 
    .form-group textarea:focus { 
        outline: none; 
        border-color: #800000; 
        background: #fff;
        box-shadow: 0 5px 15px rgba(128, 0, 0, 0.05);
    }
    .form-group textarea { height: 200px; resize: vertical; }
    
    .file-input-wrapper {
        border: 2px dashed #ddd;
        padding: 2rem;
        border-radius: 12px;
        text-align: center;
        background: #fafafa;
        cursor: pointer;
        transition: 0.3s;
    }
    .file-input-wrapper:hover { border-color: #800000; background: #fff; }
    .file-input-wrapper i { font-size: 2rem; color: #ccc; margin-bottom: 1rem; display: block; }
</style>
@endsection

@section('content')
    <div style="margin-bottom: 3rem;">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
            <a href="{{ route('admin.stories') }}" style="color: #888; text-decoration: none; font-weight: 700;"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
        <h1 style="font-size: 2.5rem; color: #333; margin: 0 0 0.5rem;">Add Success Story</h1>
        <p style="color: #888; font-size: 1.1rem; margin: 0;">Share a new story of a happy couple matched on our platform</p>
    </div>

    <div class="admin-card" style="max-width: 800px;">
        <form action="{{ route('admin.stories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Couple Name</label>
                <input type="text" name="couple_name" required placeholder="e.g., Amit & Priya">
            </div>
            
            <div class="form-group">
                <label>Their Story</label>
                <textarea name="story" required placeholder="Describe how they met and their experience with Kasar Samaj Matrimony..."></textarea>
            </div>
            
            <div class="form-group">
                <label>Couple Photo</label>
                <div class="file-input-wrapper" onclick="document.getElementById('photo-input').click()">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <div id="file-label" style="font-weight: 600; color: #666;">Click to upload or drag and drop</div>
                    <p style="font-size: 0.8rem; color: #999; margin-top: 5px;">PNG, JPG or JPEG (Max 2MB)</p>
                    <input type="file" id="photo-input" name="photo" accept="image/*" style="display: none;" onchange="updateFileName(this)">
                </div>
            </div>
            
            <div style="margin-top: 3rem; border-top: 1px solid #f0f0f0; padding-top: 2rem;">
                <button type="submit" class="btn-primary-admin" style="width: 100%; justify-content: center; padding: 1.2rem; font-size: 1.1rem;">
                    <i class="fas fa-check-circle"></i> Save Success Story
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
<script>
    function updateFileName(input) {
        const label = document.getElementById('file-label');
        if (input.files && input.files.length > 0) {
            label.innerText = 'Selected: ' + input.files[0].name;
            label.style.color = '#800000';
        }
    }
</script>
@endsection
