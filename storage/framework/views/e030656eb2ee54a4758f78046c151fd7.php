

<?php $__env->startSection('title', 'Services'); ?>
<?php $__env->startSection('page-title', 'Manage Services'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h2>All Services</h2>
        <a href="<?php echo e(route('admin.services.create')); ?>" class="btn btn-success">
            <i class="fas fa-plus"></i> Add New Service
        </a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($service->id); ?></td>
                    <td><?php echo e($service->title); ?></td>
                    <td><?php echo e(Str::limit($service->description, 100)); ?></td>
                    <td>
                        <?php if($service->image): ?>
                            <img src="<?php echo e(asset('storage/' . $service->image)); ?>" alt="<?php echo e($service->title); ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                        <?php else: ?>
                            <span style="color: #999;">No image</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo e(route('admin.services.edit', $service)); ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="<?php echo e(route('admin.services.destroy', $service)); ?>" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this service?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px;">
                        <p style="color: #999;">No services found. Create your first service!</p>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\My Files\Dev\bina-adult-care-main-master\resources\views/admin/services/index.blade.php ENDPATH**/ ?>