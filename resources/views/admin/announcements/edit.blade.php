@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header" style="background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%); color: white;">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Announcement</h5>
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

                    <form action="{{ route('admin.announcements.update', $announcement->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $announcement->title) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                                    <select class="form-select" id="type" name="type" required>
                                        <option value="bar" {{ old('type', $announcement->type) === 'bar' ? 'selected' : '' }}>Top Bar</option>
                                        <option value="popup" {{ old('type', $announcement->type) === 'popup' ? 'selected' : '' }}>Popup Modal</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="text_content" class="form-label">Text Content</label>
                                    <textarea class="form-control" id="text_content" name="text_content" rows="3">{{ old('text_content', $announcement->text_content) }}</textarea>
                                </div>

                                @if($announcement->image_path)
                                    <div class="mb-3">
                                        <label class="form-label">Current Image</label>
                                        <div class="position-relative d-inline-block">
                                            <img src="{{ $announcement->image_url }}" alt="{{ $announcement->title }}" style="max-width: 100%; max-height: 200px; border-radius: 8px;">
                                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2" onclick="deleteImage({{ $announcement->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label for="image" class="form-label">{{ $announcement->image_path ? 'Replace Image' : 'Image' }}</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                    <div id="imagePreview" class="mt-2" style="display: none;">
                                        <img id="previewImg" src="" alt="Preview" style="max-width: 100%; max-height: 300px; border-radius: 8px;">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <label for="link_url" class="form-label">Link URL</label>
                                        <input type="url" class="form-control" id="link_url" name="link_url" value="{{ old('link_url', $announcement->link_url) }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="link_text" class="form-label">Link Text</label>
                                        <input type="text" class="form-control" id="link_text" name="link_text" value="{{ old('link_text', $announcement->link_text) }}">
                                    </div>
                                </div>

                                <div class="card mb-3" id="popupSettings">
                                    <div class="card-header bg-light">
                                        <i class="fas fa-window-restore me-2"></i>Popup Settings
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="delay_seconds" class="form-label">Delay (seconds)</label>
                                            <input type="number" class="form-control" id="delay_seconds" name="delay_seconds" value="{{ old('delay_seconds', $announcement->delay_seconds) }}" min="0" max="60">
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="show_once_per_session" name="show_once_per_session" value="1" {{ old('show_once_per_session', $announcement->show_once_per_session) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="show_once_per_session">
                                                Show only once per session
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <i class="fas fa-cog me-2"></i>Display Settings
                                    </div>
                                    <div class="card-body">
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $announcement->is_active) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">
                                                Active
                                            </label>
                                        </div>

                                        <div class="mb-3" id="barColors">
                                            <label for="background_color" class="form-label">Background Color</label>
                                            <input type="color" class="form-control form-control-color" id="background_color" name="background_color" value="{{ old('background_color', $announcement->background_color) }}">
                                        </div>

                                        <div class="mb-3" id="textColor">
                                            <label for="text_color" class="form-label">Text Color</label>
                                            <input type="color" class="form-control form-control-color" id="text_color" name="text_color" value="{{ old('text_color', $announcement->text_color) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <i class="fas fa-calendar me-2"></i>Schedule
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="start_date" class="form-label">Start Date</label>
                                            <input type="datetime-local" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', $announcement->start_date?->format('Y-m-d\TH:i')) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="end_date" class="form-label">End Date</label>
                                            <input type="datetime-local" class="form-control" id="end_date" name="end_date" value="{{ old('end_date', $announcement->end_date?->format('Y-m-d\TH:i')) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Update Announcement
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

// Show/hide settings based on type
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

// Delete image
function deleteImage(id) {
    if (!confirm('Are you sure you want to delete this image?')) {
        return;
    }
    
    fetch(`/admin/announcements/${id}/delete-image`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}
</script>
@endsection
