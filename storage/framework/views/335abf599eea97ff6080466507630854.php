

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%); color: white;">
                    <h5 class="mb-0"><i class="fas fa-blog me-2"></i>Blog Management</h5>
                    <a href="<?php echo e(route('admin.blog.create')); ?>" class="btn btn-light btn-sm">
                        <i class="fas fa-plus me-1"></i> New Blog Post
                    </a>
                </div>
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if($blogs->count() > 0): ?>
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
                                    <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <?php if($blog->header_image): ?>
                                                    <img src="<?php echo e($blog->header_image_url); ?>" alt="<?php echo e($blog->title); ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                                <?php else: ?>
                                                    <div style="width: 60px; height: 60px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <strong><?php echo e(Str::limit($blog->title, 50)); ?></strong>
                                                <br>
                                                <small class="text-muted"><?php echo e(Str::limit($blog->excerpt, 80)); ?></small>
                                                <br>
                                                <small class="text-muted"><i class="fas fa-link"></i> <?php echo e($blog->slug); ?></small>
                                            </td>
                                            <td><?php echo e($blog->author_name); ?></td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input publish-toggle" type="checkbox" 
                                                           data-id="<?php echo e($blog->id); ?>" 
                                                           <?php echo e($blog->is_published ? 'checked' : ''); ?>

                                                           style="cursor: pointer;">
                                                    <label class="form-check-label small">
                                                        <?php echo e($blog->is_published ? 'Published' : 'Draft'); ?>

                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <i class="fas fa-eye text-muted"></i> <?php echo e($blog->view_count); ?>

                                            </td>
                                            <td>
                                                <?php if($blog->published_at): ?>
                                                    <small><?php echo e($blog->published_at->format('M j, Y')); ?></small>
                                                <?php else: ?>
                                                    <small class="text-muted">Not published</small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <?php if($blog->is_published): ?>
                                                        <a href="<?php echo e($blog->url); ?>" target="_blank" class="btn btn-sm btn-outline-info" title="View">
                                                            <i class="fas fa-external-link-alt"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                    <a href="<?php echo e(route('admin.blog.edit', $blog->id)); ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="<?php echo e(route('admin.blog.destroy', $blog->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this blog post?');">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            <?php echo e($blogs->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-blog fa-4x text-muted mb-3"></i>
                            <p class="text-muted">No blog posts yet. Create your first blog post to get started!</p>
                            <a href="<?php echo e(route('admin.blog.create')); ?>" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Create Blog Post
                            </a>
                        </div>
                    <?php endif; ?>
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
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\My Files\Dev\bina-adult-care-main-master\resources\views/admin/blog/index.blade.php ENDPATH**/ ?>