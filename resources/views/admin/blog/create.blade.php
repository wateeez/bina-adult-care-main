@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header" style="background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%); color: white;">
                    <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Create New Blog Post</h5>
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

                    <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Main Content -->
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="excerpt" class="form-label">Excerpt</label>
                                    <textarea class="form-control" id="excerpt" name="excerpt" rows="2" placeholder="Brief summary of the blog post">{{ old('excerpt') }}</textarea>
                                    <small class="text-muted">This will be displayed in blog listings and search results</small>
                                </div>

                                <div class="mb-3">
                                    <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="content" name="content" rows="15" required>{{ old('content') }}</textarea>
                                    <small class="text-muted">Separate paragraphs with double line breaks</small>
                                </div>

                                <!-- Header Image -->
                                <div class="mb-3">
                                    <label for="header_image" class="form-label">Header Image</label>
                                    <input type="file" class="form-control" id="header_image" name="header_image" accept="image/*">
                                    <small class="text-muted">Recommended: 1200x600px | Max: 5MB</small>
                                    <div id="headerPreview" class="mt-2" style="display: none;">
                                        <img id="headerPreviewImg" src="" alt="Preview" style="max-width: 100%; max-height: 300px; border-radius: 8px;">
                                    </div>
                                </div>

                                <!-- Paragraph Images -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <i class="fas fa-images me-2"></i>Paragraph Images (Optional)
                                    </div>
                                    <div class="card-body">
                                        <div id="paragraphImagesContainer">
                                            <div class="paragraph-image-row mb-3">
                                                <div class="row align-items-end">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Image</label>
                                                        <input type="file" class="form-control" name="paragraph_images[]" accept="image/*">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Paragraph #</label>
                                                        <input type="number" class="form-control" name="paragraph_numbers[]" value="1" min="1">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Caption</label>
                                                        <input type="text" class="form-control" name="image_captions[]" placeholder="Optional">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Alt Text</label>
                                                        <input type="text" class="form-control" name="image_alt_texts[]" placeholder="For SEO">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button type="button" class="btn btn-outline-danger btn-sm remove-para-img" style="display: none;">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-primary" id="addParagraphImage">
                                            <i class="fas fa-plus me-1"></i> Add Another Image
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Sidebar -->
                            <div class="col-md-4">
                                <!-- Publish Settings -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <i class="fas fa-cog me-2"></i>Publish Settings
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="author_name" class="form-label">Author Name</label>
                                            <input type="text" class="form-control" id="author_name" name="author_name" value="{{ old('author_name', 'Bina Adult Care') }}" required>
                                        </div>

                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_published">
                                                Publish immediately
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- SEO Settings -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <i class="fas fa-search me-2"></i>SEO Settings
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="meta_title" class="form-label">Meta Title</label>
                                            <input type="text" class="form-control" id="meta_title" name="meta_title" value="{{ old('meta_title') }}" maxlength="60">
                                            <small class="text-muted">Leave blank to use post title</small>
                                        </div>

                                        <div class="mb-3">
                                            <label for="meta_description" class="form-label">Meta Description</label>
                                            <textarea class="form-control" id="meta_description" name="meta_description" rows="3" maxlength="160">{{ old('meta_description') }}</textarea>
                                            <small class="text-muted">Recommended: 150-160 characters</small>
                                        </div>

                                        <div class="mb-3">
                                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                            <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords') }}" placeholder="keyword1, keyword2, keyword3">
                                            <small class="text-muted">Comma-separated keywords</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Create Blog Post
                                    </button>
                                    <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary">
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
// Header image preview
document.getElementById('header_image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('headerPreviewImg').src = e.target.result;
            document.getElementById('headerPreview').style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});

// Add paragraph image
document.getElementById('addParagraphImage').addEventListener('click', function() {
    const container = document.getElementById('paragraphImagesContainer');
    const newRow = container.firstElementChild.cloneNode(true);
    
    // Clear inputs
    newRow.querySelectorAll('input').forEach(input => {
        if (input.type === 'file') {
            input.value = '';
        } else if (input.type === 'number') {
            input.value = parseInt(input.value) + 1;
        } else {
            input.value = '';
        }
    });
    
    // Show remove button
    newRow.querySelector('.remove-para-img').style.display = 'block';
    
    container.appendChild(newRow);
    
    // Show remove buttons on all rows
    container.querySelectorAll('.remove-para-img').forEach(btn => btn.style.display = 'block');
});

// Remove paragraph image
document.getElementById('paragraphImagesContainer').addEventListener('click', function(e) {
    if (e.target.closest('.remove-para-img')) {
        const row = e.target.closest('.paragraph-image-row');
        if (this.querySelectorAll('.paragraph-image-row').length > 1) {
            row.remove();
        }
        
        // Hide remove button if only one row left
        if (this.querySelectorAll('.paragraph-image-row').length === 1) {
            this.querySelector('.remove-para-img').style.display = 'none';
        }
    }
});
</script>
@endsection
