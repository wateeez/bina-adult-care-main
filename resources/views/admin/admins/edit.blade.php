@extends('admin.layouts.app')

@section('title', 'Edit Admin')

@section('content')
<div class="admin-header">
    <h1><i class="fas fa-user-edit"></i> Edit Admin</h1>
    <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <h4><i class="fas fa-exclamation-circle"></i> Please fix the following errors:</h4>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-info-circle"></i> Edit Admin Account</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="email">Email Address <span class="required">*</span></label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-control @error('email') is-invalid @enderror" 
                    value="{{ old('email', $admin->email) }}" 
                    required
                >
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="role">Role <span class="required">*</span></label>
                <select id="role" name="role" class="form-control @error('role') is-invalid @enderror" required>
                    <option value="super_admin" {{ old('role', $admin->role) == 'super_admin' ? 'selected' : '' }}>
                        🔴 Super Admin (Full Access)
                    </option>
                    <option value="content_editor" {{ old('role', $admin->role) == 'content_editor' ? 'selected' : '' }}>
                        🟢 Content Editor (Content Only)
                    </option>
                </select>
                @error('role')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="is_active">Account Status <span class="required">*</span></label>
                <select id="is_active" name="is_active" class="form-control @error('is_active') is-invalid @enderror" required>
                    <option value="1" {{ old('is_active', $admin->is_active) == 1 ? 'selected' : '' }}>
                        ✅ Active (Can log in)
                    </option>
                    <option value="0" {{ old('is_active', $admin->is_active) == 0 ? 'selected' : '' }}>
                        ❌ Inactive (Cannot log in)
                    </option>
                </select>
                @error('is_active')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="info-box">
                <i class="fas fa-info-circle"></i>
                <p><strong>Note:</strong> To change this admin's password, use the "Change Password" button from the admin list page.</p>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Admin
                </button>
                <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<style>
.required {
    color: #dc3545;
}

.info-box {
    background: #e7f3ff;
    border-left: 4px solid #2196F3;
    padding: 1rem;
    margin: 1.5rem 0;
    border-radius: 4px;
}

.info-box i {
    color: #2196F3;
    margin-right: 0.5rem;
}

.info-box p {
    margin: 0;
    color: #333;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 1rem;
    border-top: 1px solid #e2e8f0;
}
</style>
@endsection
