@extends('admin.layout')

@section('title', 'Edit Service')
@section('page-title', 'Edit Service')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Edit Service: {{ $service->title }}</h2>
        <a href="{{ route('admin.services') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Back to Services
        </a>
    </div>
    <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="title">Service Title *</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $service->title) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description *</label>
            <textarea name="description" id="description" class="form-control" required>{{ old('description', $service->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="image">Service Image</label>
            @if($service->image)
                <div style="margin-bottom: 10px;">
                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}" style="max-width: 300px; border-radius: 8px;">
                    <p style="color: #666; margin-top: 5px;">Current image</p>
                </div>
            @endif
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
            <small style="color: #666;">Leave empty to keep current image. Recommended size: 600x400px. Supported formats: JPG, PNG, GIF (Max 2MB)</small>
        </div>

        <div style="margin-top: 30px;">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Update Service
            </button>
            <a href="{{ route('admin.services') }}" class="btn btn-danger">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection
