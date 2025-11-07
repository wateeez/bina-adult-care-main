

<?php $__env->startSection('title', 'Contact Messages'); ?>
<?php $__env->startSection('page-title', 'Contact Messages'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h2>All Contact Messages</h2>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($contact->id); ?></td>
                    <td><?php echo e($contact->name); ?></td>
                    <td><?php echo e($contact->email); ?></td>
                    <td><?php echo e($contact->phone); ?></td>
                    <td><?php echo e($contact->created_at->format('M d, Y H:i')); ?></td>
                    <td>
                        <a href="<?php echo e(route('admin.contacts.show', $contact)); ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <form action="<?php echo e(route('admin.contacts.destroy', $contact)); ?>" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this message?');">
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
                    <td colspan="6" style="text-align: center; padding: 40px;">
                        <p style="color: #999;">No contact messages yet.</p>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <?php if($contacts->hasPages()): ?>
        <div style="padding: 20px; text-align: center;">
            <?php echo e($contacts->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\My Files\Dev\bina-adult-care-main-master\resources\views/admin/contacts/index.blade.php ENDPATH**/ ?>