

<?php $__env->startSection('title', 'Admin Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-header">
    <h1><i class="fas fa-users-cog"></i> Admin Management</h1>
    <a href="<?php echo e(route('admin.admins.create')); ?>" class="btn btn-primary">
        <i class="fas fa-user-plus"></i> Create New Admin
    </a>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-list"></i> All Admin Accounts</h3>
        <a href="<?php echo e(route('admin.activity-logs')); ?>" class="btn btn-secondary">
            <i class="fas fa-history"></i> View Activity Logs
        </a>
    </div>
    <div class="card-body">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Last Activity</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($admin->id); ?></td>
                    <td>
                        <?php echo e($admin->email); ?>

                        <?php if($admin->id === $currentAdmin->id): ?>
                            <span class="badge badge-info">You</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($admin->role === 'super_admin'): ?>
                            <span class="badge badge-danger"><i class="fas fa-crown"></i> Super Admin</span>
                        <?php else: ?>
                            <span class="badge badge-success"><i class="fas fa-edit"></i> Content Editor</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($admin->is_active): ?>
                            <span class="badge badge-success"><i class="fas fa-check"></i> Active</span>
                        <?php else: ?>
                            <span class="badge badge-secondary"><i class="fas fa-ban"></i> Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($admin->last_activity): ?>
                            <?php echo e($admin->last_activity->diffForHumans()); ?>

                        <?php else: ?>
                            <span class="text-muted">Never</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo e($admin->created_at->format('M d, Y')); ?></td>
                    <td class="table-actions">
                        <?php if($admin->id !== $currentAdmin->id): ?>
                            <a href="<?php echo e(route('admin.admins.edit', $admin->id)); ?>" class="btn btn-sm btn-primary" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button 
                                onclick="showPasswordModal(<?php echo e($admin->id); ?>, '<?php echo e($admin->email); ?>')" 
                                class="btn btn-sm btn-warning" 
                                title="Change Password">
                                <i class="fas fa-key"></i>
                            </button>
                            <form action="<?php echo e(route('admin.admins.destroy', $admin->id)); ?>" method="POST" style="display: inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this admin?')" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center">No admins found</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Password Change Modal -->
<div id="passwordModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2><i class="fas fa-key"></i> Change Password</h2>
            <button onclick="closePasswordModal()" class="close-btn">&times;</button>
        </div>
        <form id="passwordForm" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="modal-body">
                <p>Change password for: <strong id="adminEmail"></strong></p>
                
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password" class="form-control" required>
                    <small class="form-text">Must be 8+ characters with uppercase, lowercase, number, and special character</small>
                </div>

                <div class="form-group">
                    <label for="new_password_confirmation">Confirm Password</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closePasswordModal()" class="btn btn-secondary">Cancel</button>
                <button type="submit" class="btn btn-primary">Change Password</button>
            </div>
        </form>
    </div>
</div>

<style>
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.modal-content {
    background: white;
    border-radius: 8px;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.2);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-bottom: 1px solid #e2e8f0;
}

.modal-header h2 {
    margin: 0;
    font-size: 1.5rem;
}

.close-btn {
    background: none;
    border: none;
    font-size: 2rem;
    cursor: pointer;
    color: #999;
}

.close-btn:hover {
    color: #333;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    padding: 1.5rem;
    border-top: 1px solid #e2e8f0;
}

.badge {
    padding: 0.35rem 0.65rem;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 600;
}

.badge-danger {
    background: #dc3545;
    color: white;
}

.badge-success {
    background: #28a745;
    color: white;
}

.badge-info {
    background: #17a2b8;
    color: white;
}

.badge-secondary {
    background: #6c757d;
    color: white;
}

.text-muted {
    color: #6c757d;
}
</style>

<script>
function showPasswordModal(adminId, email) {
    document.getElementById('adminEmail').textContent = email;
    document.getElementById('passwordForm').action = `/admin/admins/${adminId}/change-password`;
    document.getElementById('passwordModal').style.display = 'flex';
}

function closePasswordModal() {
    document.getElementById('passwordModal').style.display = 'none';
    document.getElementById('passwordForm').reset();
}

// Close modal when clicking outside
document.getElementById('passwordModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closePasswordModal();
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\My Files\Dev\bina-adult-care-main-master\resources\views/admin/admins/index.blade.php ENDPATH**/ ?>