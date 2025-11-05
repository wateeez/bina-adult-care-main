@extends('admin.layout')

@section('title', 'Content Management')
@section('page-title', 'Content Management')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Manage Website Content</h2>
    </div>
    
    @forelse($contents as $content)
        <div style="padding: 20px; border-bottom: 1px solid #ddd;">
            <form action="{{ route('admin.content.update', ['section' => $content->section]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="content_{{ $content->id }}">
                        <strong>{{ ucfirst(str_replace('_', ' ', $content->section)) }}</strong>
                    </label>
                    <textarea name="content" id="content_{{ $content->id }}" class="form-control" rows="5">{{ old('content', $content->content) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="background_image_{{ $content->id }}">Background Image</label>
                    @if($content->background_image)
                        <div style="margin-bottom: 10px;">
                            <img src="{{ asset('storage/' . $content->background_image) }}" alt="{{ $content->section }} background" style="max-width: 300px; border-radius: 8px;">
                            <p style="color: #666; margin-top: 5px;">Current background image</p>
                        </div>
                    @endif
                    <input type="file" name="background_image" id="background_image_{{ $content->id }}" class="form-control" accept="image/*">
                    <small style="color: #666;">Leave empty to keep current background. Recommended size: 1920x600px. Supported formats: JPG, PNG, GIF (Max 2MB)</small>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Update {{ ucfirst($content->section) }}
                </button>
            </form>
        </div>
    @empty
        <div style="padding: 40px; text-align: center;">
            <p style="color: #999;">No content sections found.</p>
        </div>
    @endforelse
</div>
@endsection
