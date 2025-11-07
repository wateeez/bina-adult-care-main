@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header" style="background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%); color: white;">
                    <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Create New Announcement</h5>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                                    <small class="text-muted">Internal reference name</small>
                                </div>

                                <div class="mb-3">
                                    <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                                    <select class="form-select" id="type" name="type" required>
                                        <option value="bar" {{ old('type') === 'bar' ? 'selected' : '' }}>Top Bar</option>
                                        <option value="popup" {{ old('type') === 'popup' ? 'selected' : '' }}>Popup Modal</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="text_content" class="form-label">Text Content</label>
                                    <textarea class="form-control" id="text_content" name="text_content" rows="3">{{ old('text_content') }}</textarea>
                                    <small class="text-muted">Leave empty to show image only</small>
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                    <small class="text-muted">For bar: 1200x80px recommended. For popup: 800x600px recommended. Max: 5MB</small>
                                    <div id="imagePreview" class="mt-2" style="display: none;">
                                        <img id="previewImg" src="" alt="Preview" style="max-width: 100%; max-height: 300px; border-radius: 8px;">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <label for="link_url" class="form-label">Link URL</label>
                                        <input type="url" class="form-control" id="link_url" name="link_url" value="{{ old('link_url') }}" placeholder="https://example.com">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="link_text" class="form-label">Link Text</label>
                                        <input type="text" class="form-control" id="link_text" name="link_text" value="{{ old('link_text', 'Learn More') }}">
                                    </div>
                                </div>

                                <div class="card mb-3" id="popupSettings" style="display: none;">
                                    <div class="card-header bg-light">
                                        <i class="fas fa-window-restore me-2"></i>Popup Settings
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="delay_seconds" class="form-label">Delay (seconds)</label>
                                            <input type="number" class="form-control" id="delay_seconds" name="delay_seconds" value="{{ old('delay_seconds', 3) }}" min="0" max="60">
                                            <small class="text-muted">How long to wait before showing popup</small>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="show_once_per_session" name="show_once_per_session" value="1" {{ old('show_once_per_session', true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="show_once_per_session">
                                                Show only once per session
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sidebar -->
                            <div class="col-md-4">
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <i class="fas fa-cog me-2"></i>Display Settings
                                    </div>
                                    <div class="card-body">
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">
                                                Active
                                            </label>
                                        </div>

                                        <div class="mb-3" id="barColors">
                                            <label for="background_color" class="form-label">Background Color</label>
                                            <input type="color" class="form-control form-control-color" id="background_color" name="background_color" value="{{ old('background_color', '#4A90E2') }}">
                                        </div>

                                        <div class="mb-3" id="textColor">
                                            <label for="text_color" class="form-label">Text Color</label>
                                            <input type="color" class="form-control form-control-color" id="text_color" name="text_color" value="{{ old('text_color', '#ffffff') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <i class="fas fa-calendar me-2"></i>Schedule (Optional)
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="start_date" class="form-label">Start Date</label>
                                            <input type="datetime-local" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="end_date" class="form-label">End Date</label>
                                            <input type="datetime-local" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}">
                                        </div>
                                        <small class="text-muted">Leave empty for always active</small>
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Create Announcement
                                    </button>
                                    <a href="{{ route('admin.announcements.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.btn-primary {
    background: #4A90E2;
    border-color: #4A90E2;
}

.btn-primary:hover {
    background: #357ABD;
    border-color: #357ABD;
}

.form-check-input:checked {
    background-color: #4A90E2;
    border-color: #4A90E2;
}
</style>

<script>
// Image preview
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});

// Show/hide popup settings based on type
document.getElementById('type').addEventListener('change', function() {
    const popupSettings = document.getElementById('popupSettings');
    const barColors = document.getElementById('barColors');
    const textColor = document.getElementById('textColor');
    
    if (this.value === 'popup') {
        popupSettings.style.display = 'block';
        barColors.style.display = 'none';
        textColor.style.display = 'none';
    } else {
        popupSettings.style.display = 'none';
        barColors.style.display = 'block';
        textColor.style.display = 'block';
    }
});

// Trigger on load
document.getElementById('type').dispatchEvent(new Event('change'));
</script>
@endsection
