

<?php $__env->startSection('content'); ?>
<div class="admin-header">
    <h1><i class="fas fa-cog"></i> Site Settings</h1>
</div>

<div class="card">
    <div class="card-header">
        <div>
            <h3><i class="fas fa-image"></i> Site Logo</h3>
            <p>Upload and manage your website logo (visible to all users)</p>
        </div>
    </div>
    <div class="card-body">
        <!-- Current Logo Display -->
        <div style="margin-bottom: 2rem;">
            <h4 style="margin-bottom: 1rem;">Current Logo</h4>
            <div style="padding: 2rem; background: #f8f9fa; border-radius: 10px; text-align: center;">
                <?php if($logo): ?>
                    <img src="<?php echo e(asset('storage/' . $logo)); ?>" alt="Site Logo" style="max-width: 300px; max-height: 150px; object-fit: contain;">
                    <div style="margin-top: 1rem;">
                        <form action="<?php echo e(route('admin.settings.logo.remove')); ?>" method="POST" style="display: inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to remove the logo?')">
                                <i class="fas fa-trash"></i> Remove Logo
                            </button>
                        </form>
                    </div>
                <?php else: ?>
                    <div style="color: #6c757d; font-size: 3rem; margin-bottom: 1rem;">
                        <i class="fas fa-image"></i>
                    </div>
                    <p style="color: #6c757d; margin: 0;">No logo uploaded. Using site name as fallback.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Upload New Logo Form -->
        <form action="<?php echo e(route('admin.settings.logo.update')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label for="logo"><i class="fas fa-upload"></i> Upload New Logo</label>
                <input type="file" id="logo" name="logo" class="form-control <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" accept="image/*" onchange="previewLogo(event)">
                <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="error-message"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <small class="form-text">Recommended: PNG or SVG format, max 2MB. Best size: 200x80 pixels.</small>
            </div>

            <!-- Image Preview -->
            <div id="logoPreview" style="display: none; margin-top: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 10px; text-align: center;">
                <h5>Preview</h5>
                <img id="previewImage" src="" alt="Logo Preview" style="max-width: 300px; max-height: 150px; object-fit: contain;">
            </div>

            <button type="submit" class="btn btn-primary" style="margin-top: 1rem;">
                <i class="fas fa-save"></i> Upload Logo
            </button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div>
            <h3><i class="fas fa-heading"></i> Site Name</h3>
            <p>Fallback text when no logo is uploaded</p>
        </div>
    </div>
    <div class="card-body">
        <form action="<?php echo e(route('admin.settings.sitename.update')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label for="site_name">Site Name</label>
                <input type="text" id="site_name" name="site_name" class="form-control <?php $__errorArgs = ['site_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('site_name', $siteName)); ?>" required>
                <?php $__errorArgs = ['site_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="error-message"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Site Name
            </button>
        </form>
    </div>
</div>

<script>
    function previewLogo(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImage').src = e.target.result;
                document.getElementById('logoPreview').style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            document.getElementById('logoPreview').style.display = 'none';
        }
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\My Files\Dev\bina-adult-care-main-master\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>