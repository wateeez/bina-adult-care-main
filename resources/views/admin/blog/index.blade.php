@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%); color: white;">
                    <h5 class="mb-0"><i class="fas fa-blog me-2"></i>Blog Management</h5>
                    <a href="{{ route('admin.blog.create') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-plus me-1"></i> New Blog Post
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($blogs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 80px;">Image</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Status</th>
                                        <th>Views</th>
                                        <th>Published</th>
                                        <th style="width: 180px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($blogs as $blog)
                                        <tr>
                                            <td>
                                                @if($blog->header_image)
                                                    <img src="{{ $blog->header_image_url }}" alt="{{ $blog->title }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                                @else
                                                    <div style="width: 60px; height: 60px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{ Str::limit($blog->title, 50) }}</strong>
                                                <br>
                                                <small class="text-muted">{{ Str::limit($blog->excerpt, 80) }}</small>
                                                <br>
                                                <small class="text-muted"><i class="fas fa-link"></i> {{ $blog->slug }}</small>
                                            </td>
                                            <td>{{ $blog->author_name }}</td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input publish-toggle" type="checkbox" 
                                                           data-id="{{ $blog->id }}" 
                                                           {{ $blog->is_published ? 'checked' : '' }}
                                                           style="cursor: pointer;">
                                                    <label class="form-check-label small">
                                                        {{ $blog->is_published ? 'Published' : 'Draft' }}
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <i class="fas fa-eye text-muted"></i> {{ $blog->view_count }}
                                            </td>
                                            <td>
                                                @if($blog->published_at)
                                                    <small>{{ $blog->published_at->format('M j, Y') }}</small>
                                                @else
                                                    <small class="text-muted">Not published</small>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    @if($blog->is_published)
                                                        <a href="{{ $blog->url }}" target="_blank" class="btn btn-sm btn-outline-info" title="View">
                                                            <i class="fas fa-external-link-alt"></i>
                                                        </a>
                                                    @endif
                                                    <a href="{{ route('admin.blog.edit', $blog->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.blog.destroy', $blog->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this blog post?');">
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

                        <div class="mt-4">
                            {{ $blogs->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-blog fa-4x text-muted mb-3"></i>
                            <p class="text-muted">No blog posts yet. Create your first blog post to get started!</p>
                            <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Create Blog Post
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

.btn-outline-primary {
    color: #4A90E2;
    border-color: #4A90E2;
}

.btn-outline-primary:hover {
    background: #4A90E2;
    border-color: #4A90E2;
}

.form-check-input:checked {
    background-color: #4A90E2;
    border-color: #4A90E2;
}
</style>

<script>
// Publish toggle
document.querySelectorAll('.publish-toggle').forEach(toggle => {
    toggle.addEventListener('change', function() {
        const blogId = this.dataset.id;
        const isPublished = this.checked;
        
        fetch(`/admin/blog/${blogId}/toggle-publish`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.nextElementSibling.textContent = data.is_published ? 'Published' : 'Draft';
                
                // Show success message
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
                this.checked = !isPublished;
                alert('Error updating status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            this.checked = !isPublished;
            alert('Error updating status');
        });
    });
});
</script>
@endsection
