

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%); color: white;">
                    <h5 class="mb-0"><i class="fas fa-images me-2"></i>Photo Gallery Management</h5>
                    <span class="badge bg-white text-primary"><?php echo e($images->count()); ?>/10 Images</span>
                </div>
                <div class="card-body">
                    <!-- Homepage Display Toggle -->
                    <div class="alert alert-info d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <i class="fas fa-home me-2"></i>
                            <strong>Display Gallery on Homepage</strong>
                            <p class="mb-0 small text-muted">Toggle to show/hide gallery section on the homepage</p>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="homepageToggle" 
                                   <?php echo e($showOnHomepage ? 'checked' : ''); ?>

                                   style="width: 3rem; height: 1.5rem; cursor: pointer;">
                        </div>
                    </div>

                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Upload Form -->
                    <?php if($images->count() < 10): ?>
                        <div class="card border-primary mb-4">
                            <div class="card-header bg-primary text-white">
                                <i class="fas fa-cloud-upload-alt me-2"></i>Upload New Image
                            </div>
                            <div class="card-body">
                                <form action="<?php echo e(route('admin.gallery.store')); ?>" method="POST" enctype="multipart/form-data" id="uploadForm">
                                    <?php echo csrf_field(); ?>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="image" class="form-label">Image File <span class="text-danger">*</span></label>
                                            <input type="file" class="form-control" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/gif" required>
                                            <small class="text-muted">Max size: 5MB | Formats: JPEG, PNG, JPG, GIF</small>
                                            
                                            <!-- Image Preview -->
                                            <div id="imagePreview" class="mt-3" style="display: none;">
                                                <img id="previewImg" src="" alt="Preview" style="max-width: 100%; max-height: 300px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="title" class="form-label">Title (Optional)</label>
                                                <input type="text" class="form-control" id="title" name="title" maxlength="255">
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description (Optional)</label>
                                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="fas fa-upload me-2"></i>Upload Image
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Maximum Limit Reached!</strong> You can upload a maximum of 10 images. Please delete an existing image to upload a new one.
                        </div>
                    <?php endif; ?>

                    <!-- Gallery Images List -->
                    <div class="card">
                        <div class="card-header bg-light">
                            <i class="fas fa-th-large me-2"></i>Gallery Images
                            <?php if($images->count() > 0): ?>
                                <small class="text-muted">(Drag and drop to reorder)</small>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <?php if($images->count() > 0): ?>
                                <div id="sortableGallery" class="row">
                                    <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-md-6 col-lg-4 mb-4 gallery-item" data-id="<?php echo e($image->id); ?>" style="cursor: move;">
                                            <div class="card h-100 shadow-sm" style="transition: all 0.3s;">
                                                <img src="<?php echo e($image->image_url); ?>" class="card-img-top" alt="<?php echo e($image->title ?? 'Gallery Image'); ?>" style="height: 200px; object-fit: cover;">
                                                <div class="card-body">
                                                    <h6 class="card-title"><?php echo e($image->title ?? 'Untitled'); ?></h6>
                                                    <p class="card-text text-muted small"><?php echo e($image->description ? Str::limit($image->description, 80) : 'No description'); ?></p>
                                                    
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <small class="text-muted">Order: <?php echo e($image->order); ?></small>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input status-toggle" type="checkbox" data-id="<?php echo e($image->id); ?>" <?php echo e($image->is_active ? 'checked' : ''); ?>>
                                                            <label class="form-check-label small">Active</label>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="d-flex gap-2">
                                                        <button class="btn btn-sm btn-outline-primary flex-fill" onclick="editImage(<?php echo e($image->id); ?>, '<?php echo e($image->title); ?>', '<?php echo e($image->description); ?>')">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                        <form action="<?php echo e(route('admin.gallery.destroy', $image->id)); ?>" method="POST" class="flex-fill" onsubmit="return confirm('Are you sure you want to delete this image?');">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                            <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <i class="fas fa-images fa-4x text-muted mb-3"></i>
                                    <p class="text-muted">No images uploaded yet. Upload your first image to get started!</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Image Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="editTitle" name="title" maxlength="255">
                    </div>
                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editDescription" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.gallery-item:hover .card {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
}

.sortable-ghost {
    opacity: 0.4;
}

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

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
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

// Homepage toggle
document.getElementById('homepageToggle').addEventListener('change', function() {
    const isChecked = this.checked;
    
    fetch('<?php echo e(route("admin.gallery.toggle-homepage")); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        },
        body: JSON.stringify({ show: isChecked })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success alert-dismissible fade show';
            alertDiv.innerHTML = `
                <i class="fas fa-check-circle me-2"></i>${data.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.querySelector('.card-body').insertBefore(alertDiv, document.querySelector('.card-body').firstChild);
            
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the setting.');
        this.checked = !isChecked;
    });
});

// Status toggle
document.querySelectorAll('.status-toggle').forEach(toggle => {
    toggle.addEventListener('change', function() {
        const imageId = this.dataset.id;
        const isActive = this.checked;
        
        fetch(`/admin/gallery/${imageId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({ is_active: isActive })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                alert('Error updating status');
                this.checked = !isActive;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            this.checked = !isActive;
        });
    });
});

// Sortable for drag and drop reordering
<?php if($images->count() > 0): ?>
const sortable = new Sortable(document.getElementById('sortableGallery'), {
    animation: 150,
    ghostClass: 'sortable-ghost',
    onEnd: function(evt) {
        const order = [];
        document.querySelectorAll('.gallery-item').forEach((item, index) => {
            order.push({
                id: item.dataset.id,
                order: index
            });
        });
        
        fetch('<?php echo e(route("admin.gallery.update-order")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({ order: order })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating order');
        });
    }
});
<?php endif; ?>

// Edit modal
function editImage(id, title, description) {
    document.getElementById('editTitle').value = title || '';
    document.getElementById('editDescription').value = description || '';
    document.getElementById('editForm').action = `/admin/gallery/${id}`;
    
    const modal = new bootstrap.Modal(document.getElementById('editModal'));
    modal.show();
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\My Files\Dev\bina-adult-care-main-master\resources\views/admin/gallery/index.blade.php ENDPATH**/ ?>