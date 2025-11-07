@extends('admin.layouts.app')

@section('content')
<div class="admin-header">
    <h1><i class="fas fa-cog"></i> Site Settings</h1>
</div>

<div class="card">
    <div class="card-header">
        <div>
            <h3><i class="fas fa-image"></i> Site Logo</h3>
            <p>Upload and manage your website logo (visible to all users)</p>
        </div>
    </div>
    <div class="card-body">
        <!-- Current Logo Display -->
        <div style="margin-bottom: 2rem;">
            <h4 style="margin-bottom: 1rem;">Current Logo</h4>
            <div style="padding: 2rem; background: #f8f9fa; border-radius: 10px; text-align: center;">
                @if($logo)
                    <img src="{{ asset('storage/' . $logo) }}" alt="Site Logo" style="max-width: 300px; max-height: 150px; object-fit: contain;">
                    <div style="margin-top: 1rem;">
                        <form action="{{ route('admin.settings.logo.remove') }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to remove the logo?')">
                                <i class="fas fa-trash"></i> Remove Logo
                            </button>
                        </form>
                    </div>
                @else
                    <div style="color: #6c757d; font-size: 3rem; margin-bottom: 1rem;">
                        <i class="fas fa-image"></i>
                    </div>
                    <p style="color: #6c757d; margin: 0;">No logo uploaded. Using site name as fallback.</p>
                @endif
            </div>
        </div>

        <!-- Upload New Logo Form -->
        <form action="{{ route('admin.settings.logo.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="logo"><i class="fas fa-upload"></i> Upload New Logo</label>
                <input type="file" id="logo" name="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*" onchange="previewLogo(event)">
                @error('logo')
                    <span class="error-message">{{ $message }}</span>
                @enderror
                <small class="form-text">Recommended: PNG or SVG format, max 2MB. Best size: 200x80 pixels.</small>
            </div>

            <!-- Image Preview -->
            <div id="logoPreview" style="display: none; margin-top: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 10px; text-align: center;">
                <h5>Preview</h5>
                <img id="previewImage" src="" alt="Logo Preview" style="max-width: 300px; max-height: 150px; object-fit: contain;">
            </div>

            <button type="submit" class="btn btn-primary" style="margin-top: 1rem;">
                <i class="fas fa-save"></i> Upload Logo
            </button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div>
            <h3><i class="fas fa-heading"></i> Site Name</h3>
            <p>Fallback text when no logo is uploaded</p>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.settings.sitename.update') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="site_name">Site Name</label>
                <input type="text" id="site_name" name="site_name" class="form-control @error('site_name') is-invalid @enderror" value="{{ old('site_name', $siteName) }}" required>
                @error('site_name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Site Name
            </button>
        </form>
    </div>
</div>

<script>
    function previewLogo(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImage').src = e.target.result;
                document.getElementById('logoPreview').style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            document.getElementById('logoPreview').style.display = 'none';
        }
    }
</script>
@endsection
