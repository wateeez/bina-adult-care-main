@extends('admin.layout')

@section('title', 'Create Service')
@section('page-title', 'Create New Service')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Add New Service</h2>
        <a href="{{ route('admin.services') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Back to Services
        </a>
    </div>
    <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="title">Service Title *</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description *</label>
            <textarea name="description" id="description" class="form-control" required>{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="image">Service Image</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
            <small style="color: #666;">Recommended size: 600x400px. Supported formats: JPG, PNG, GIF (Max 2MB)</small>
        </div>

        <div style="margin-top: 30px;">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Create Service
            </button>
            <a href="{{ route('admin.services') }}" class="btn btn-danger">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection
