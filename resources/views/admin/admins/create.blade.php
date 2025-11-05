@extends('admin.layouts.app')

@section('title', 'Create Admin')

@section('content')
<div class="admin-header">
    <h1><i class="fas fa-user-plus"></i> Create New Admin</h1>
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
        <h3><i class="fas fa-info-circle"></i> Admin Account Information</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.admins.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email">Email Address <span class="required">*</span></label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-control @error('email') is-invalid @enderror" 
                    value="{{ old('email') }}" 
                    required
                >
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
                <small class="form-text">This will be used to log in to the admin panel</small>
            </div>

            <div class="form-group">
                <label for="role">Role <span class="required">*</span></label>
                <select id="role" name="role" class="form-control @error('role') is-invalid @enderror" required>
                    <option value="">Select Role</option>
                    <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>
                        🔴 Super Admin (Full Access - Can manage admins & change passwords)
                    </option>
                    <option value="content_editor" {{ old('role') == 'content_editor' ? 'selected' : '' }}>
                        🟢 Content Editor (Can only update website content)
                    </option>
                </select>
                @error('role')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password <span class="required">*</span></label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        required
                    >
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                    <small class="form-text">Minimum 8 characters, must include uppercase, lowercase, number, and special character</small>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password <span class="required">*</span></label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        class="form-control" 
                        required
                    >
                </div>
            </div>

            <div class="password-strength" id="passwordStrength" style="display: none;">
                <h4>Password Requirements:</h4>
                <ul>
                    <li id="length" class="invalid"><i class="fas fa-times"></i> At least 8 characters</li>
                    <li id="uppercase" class="invalid"><i class="fas fa-times"></i> One uppercase letter</li>
                    <li id="lowercase" class="invalid"><i class="fas fa-times"></i> One lowercase letter</li>
                    <li id="number" class="invalid"><i class="fas fa-times"></i> One number</li>
                    <li id="special" class="invalid"><i class="fas fa-times"></i> One special character</li>
                </ul>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Create Admin Account
                </button>
                <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<style>
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.required {
    color: #dc3545;
}

.password-strength {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    padding: 1rem;
    margin: 1rem 0;
}

.password-strength h4 {
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.password-strength ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.password-strength li {
    padding: 0.25rem 0;
    font-size: 0.875rem;
}

.password-strength li.valid {
    color: #28a745;
}

.password-strength li.valid i {
    color: #28a745;
}

.password-strength li.invalid {
    color: #dc3545;
}

.password-strength li.invalid i {
    color: #dc3545;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 1rem;
    border-top: 1px solid #e2e8f0;
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
const passwordInput = document.getElementById('password');
const strengthDiv = document.getElementById('passwordStrength');

passwordInput.addEventListener('focus', function() {
    strengthDiv.style.display = 'block';
});

passwordInput.addEventListener('input', function() {
    const password = this.value;
    
    // Check length
    const lengthCheck = document.getElementById('length');
    if (password.length >= 8) {
        lengthCheck.classList.remove('invalid');
        lengthCheck.classList.add('valid');
        lengthCheck.innerHTML = '<i class="fas fa-check"></i> At least 8 characters';
    } else {
        lengthCheck.classList.remove('valid');
        lengthCheck.classList.add('invalid');
        lengthCheck.innerHTML = '<i class="fas fa-times"></i> At least 8 characters';
    }
    
    // Check uppercase
    const uppercaseCheck = document.getElementById('uppercase');
    if (/[A-Z]/.test(password)) {
        uppercaseCheck.classList.remove('invalid');
        uppercaseCheck.classList.add('valid');
        uppercaseCheck.innerHTML = '<i class="fas fa-check"></i> One uppercase letter';
    } else {
        uppercaseCheck.classList.remove('valid');
        uppercaseCheck.classList.add('invalid');
        uppercaseCheck.innerHTML = '<i class="fas fa-times"></i> One uppercase letter';
    }
    
    // Check lowercase
    const lowercaseCheck = document.getElementById('lowercase');
    if (/[a-z]/.test(password)) {
        lowercaseCheck.classList.remove('invalid');
        lowercaseCheck.classList.add('valid');
        lowercaseCheck.innerHTML = '<i class="fas fa-check"></i> One lowercase letter';
    } else {
        lowercaseCheck.classList.remove('valid');
        lowercaseCheck.classList.add('invalid');
        lowercaseCheck.innerHTML = '<i class="fas fa-times"></i> One lowercase letter';
    }
    
    // Check number
    const numberCheck = document.getElementById('number');
    if (/[0-9]/.test(password)) {
        numberCheck.classList.remove('invalid');
        numberCheck.classList.add('valid');
        numberCheck.innerHTML = '<i class="fas fa-check"></i> One number';
    } else {
        numberCheck.classList.remove('valid');
        numberCheck.classList.add('invalid');
        numberCheck.innerHTML = '<i class="fas fa-times"></i> One number';
    }
    
    // Check special character
    const specialCheck = document.getElementById('special');
    if (/[^A-Za-z0-9]/.test(password)) {
        specialCheck.classList.remove('invalid');
        specialCheck.classList.add('valid');
        specialCheck.innerHTML = '<i class="fas fa-check"></i> One special character';
    } else {
        specialCheck.classList.remove('valid');
        specialCheck.classList.add('invalid');
        specialCheck.innerHTML = '<i class="fas fa-times"></i> One special character';
    }
});
</script>
@endsection
