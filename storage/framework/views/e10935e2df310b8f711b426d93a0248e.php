

<?php $__env->startSection('title', 'Benefits Management'); ?>
<?php $__env->startSection('page-title', 'Benefits Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h2>Manage Benefits</h2>
        <a href="<?php echo e(route('admin.benefits.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Benefit
        </a>
    </div>
    
    <?php if($benefits->isEmpty()): ?>
        <div style="padding: 40px; text-align: center;">
            <p style="color: #999;">No benefits found. Click "Add New Benefit" to create one.</p>
        </div>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Icon</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $benefits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $benefit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($benefit->order); ?></td>
                    <td>
                        <i class="<?php echo e($benefit->icon); ?>" style="font-size: 24px; color: var(--primary-color);"></i>
                    </td>
                    <td><?php echo e($benefit->title); ?></td>
                    <td><?php echo e(Str::limit($benefit->description, 50)); ?></td>
                    <td>
                        <a href="<?php echo e(route('admin.benefits.edit', $benefit)); ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="<?php echo e(route('admin.benefits.destroy', $benefit)); ?>" method="POST" style="display: inline-block;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this benefit?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\My Files\Dev\bina-adult-care-main-master\resources\views/admin/benefits/index.blade.php ENDPATH**/ ?>