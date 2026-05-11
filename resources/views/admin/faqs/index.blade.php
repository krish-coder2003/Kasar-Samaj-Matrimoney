@extends('layouts.admin')

@section('title', 'Manage FAQs')

@section('styles')
<style>
    .form-group { margin-bottom: 1.5rem; }
    .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 700; color: #333; }
    .form-group input, .form-group textarea { width: 100%; padding: 1rem; border: 2px solid #f0f0f0; border-radius: 10px; font-family: inherit; transition: 0.3s; }
    .form-group input:focus, .form-group textarea:focus { border-color: #800000; outline: none; background: #fff; }
    .form-group textarea { height: 100px; }
    
    table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
    th, td { text-align: left; padding: 1.2rem 1rem; border-bottom: 1px solid #f0f0f0; }
    th { color: #888; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; font-weight: 700; }
    
    .faq-card { padding: 1.5rem; border: 1px solid #eee; border-radius: 15px; margin-bottom: 1.5rem; background: #fff; transition: 0.3s; }
    .faq-card:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
    
    .btn-delete-faq { background: rgba(255, 71, 87, 0.1); color: #ff4757; border: 1px solid rgba(255, 71, 87, 0.2); padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: 700; cursor: pointer; transition: 0.3s; font-size: 0.85rem; }
    .btn-delete-faq:hover { background: #ff4757; color: white; }
</style>
@endsection

@section('content')
    <div style="margin-bottom: 3rem;">
        <h1 style="font-size: 2.5rem; color: #333; margin: 0 0 0.5rem;">Frequently Asked Questions</h1>
        <p style="color: #888; font-size: 1.1rem; margin: 0;">Manage the FAQ section for your users</p>
    </div>

    @if(session('success'))
        <div class="admin-card" style="background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; padding: 1rem 2rem; margin-bottom: 2rem;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="admin-card" style="max-width: 800px;">
        <h3 style="margin: 0 0 1.5rem; font-size: 1.3rem;">Add New FAQ</h3>
        <form action="{{ route('admin.faqs.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Question</label>
                <input type="text" name="question" required placeholder="Enter the user's question">
            </div>
            <div class="form-group">
                <label>Answer</label>
                <textarea name="answer" required placeholder="Enter the detailed answer"></textarea>
            </div>
            <button type="submit" class="btn-primary-admin">
                <i class="fas fa-plus-circle"></i> Add FAQ to List
            </button>
        </form>
    </div>

    <div class="admin-card">
        <h3 style="margin: 0 0 2rem; font-size: 1.3rem;">Existing FAQs</h3>
        
        <!-- Desktop View -->
        <div class="desktop-only" style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Answer Snippet</th>
                        <th style="text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($faqs as $faq)
                    <tr>
                        <td style="font-weight: 800; color: #333; width: 30%;">{{ $faq->question }}</td>
                        <td style="color: #666; font-size: 0.95rem; line-height: 1.5;">{{ Str::limit($faq->answer, 120) }}</td>
                        <td style="text-align: right;">
                            <form action="{{ route('admin.faqs.delete', $faq) }}" method="POST" onsubmit="return confirm('Delete this FAQ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-delete-faq">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="text-align: center; color: #888; padding: 5rem;">No FAQs added yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile View -->
        <div class="mobile-only">
            @forelse($faqs as $faq)
            <div class="faq-card">
                <div style="margin-bottom: 1.5rem;">
                    <h4 style="margin: 0 0 0.8rem; color: #800000; font-size: 1.1rem; font-weight: 800;">{{ $faq->question }}</h4>
                    <p style="margin: 0; color: #666; font-size: 1rem; line-height: 1.6;">{{ $faq->answer }}</p>
                </div>
                <div style="display: flex; justify-content: flex-end;">
                    <form action="{{ route('admin.faqs.delete', $faq) }}" method="POST" onsubmit="return confirm('Delete this FAQ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-delete-faq" style="width: 100%;">Delete FAQ</button>
                    </form>
                </div>
            </div>
            @empty
            <div style="text-align: center; color: #888; padding: 4rem;">No FAQs added yet.</div>
            @endforelse
        </div>
    </div>
@endsection
