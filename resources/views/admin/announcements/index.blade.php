@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%); color: white;">
                    <h5 class="mb-0"><i class="fas fa-bullhorn me-2"></i>Announcement Management</h5>
                    <a href="{{ route('admin.announcements.create') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-plus me-1"></i> New Announcement
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($announcements->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Content</th>
                                        <th>Status</th>
                                        <th>Schedule</th>
                                        <th style="width: 180px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($announcements as $announcement)
                                        <tr>
                                            <td>
                                                <strong>{{ $announcement->title }}</strong>
                                                @if($announcement->image_path)
                                                    <br><small class="text-muted"><i class="fas fa-image"></i> Has image</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if($announcement->type === 'bar')
                                                    <span class="badge bg-info"><i class="fas fa-bars"></i> Top Bar</span>
                                                @else
                                                    <span class="badge bg-warning"><i class="fas fa-window-restore"></i> Popup</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small>{{ Str::limit($announcement->text_content, 50) }}</small>
                                                @if($announcement->link_url)
                                                    <br><small class="text-muted"><i class="fas fa-link"></i> {{ $announcement->link_text }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input status-toggle" type="checkbox" 
                                                           data-id="{{ $announcement->id }}" 
                                                           {{ $announcement->is_active ? 'checked' : '' }}
                                                           style="cursor: pointer;">
                                                    <label class="form-check-label small">
                                                        {{ $announcement->status }}
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                @if($announcement->start_date || $announcement->end_date)
                                                    <small>
                                                        @if($announcement->start_date)
                                                            <i class="fas fa-play"></i> {{ $announcement->start_date->format('M j') }}
                                                        @endif
                                                        @if($announcement->end_date)
                                                            <br><i class="fas fa-stop"></i> {{ $announcement->end_date->format('M j') }}
                                                        @endif
                                                    </small>
                                                @else
                                                    <small class="text-muted">Always</small>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this announcement?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-bullhorn fa-4x text-muted mb-3"></i>
                            <p class="text-muted">No announcements yet. Create your first announcement!</p>
                            <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Create Announcement
                            </a>
                        </div>
                    @endif
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
// Status toggle
document.querySelectorAll('.status-toggle').forEach(toggle => {
    toggle.addEventListener('change', function() {
        const announcementId = this.dataset.id;
        const isActive = this.checked;
        
        fetch(`/admin/announcements/${announcementId}/toggle`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.nextElementSibling.textContent = data.is_active ? 'Active' : 'Inactive';
                
                const alert = document.createElement('div');
                alert.className = 'alert alert-success alert-dismissible fade show position-fixed';
                alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                alert.innerHTML = `
                    <i class="fas fa-check-circle me-2"></i>${data.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.body.appendChild(alert);
                setTimeout(() => alert.remove(), 3000);
            } else {
                this.checked = !isActive;
                alert('Error updating status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            this.checked = !isActive;
        });
    });
});
</script>
@endsection
