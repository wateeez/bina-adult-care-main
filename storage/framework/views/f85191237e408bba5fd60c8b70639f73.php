<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Admin Dashboard'); ?> - Bina Adult Care</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 20px;
            background-color: #1a252f;
            text-align: center;
        }

        .sidebar-header h2 {
            font-size: 1.2rem;
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
        }

        .sidebar-menu li {
            margin-bottom: 5px;
        }

        .sidebar-menu a {
            display: block;
            padding: 15px 20px;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background-color: #34495e;
        }

        .sidebar-menu i {
            margin-right: 10px;
            width: 20px;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 250px;
        }

        /* Top Bar */
        .topbar {
            background-color: white;
            padding: 15px 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar h1 {
            font-size: 1.5rem;
            color: #2c3e50;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logout-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .logout-btn:hover {
            background-color: #c0392b;
        }

        /* Content Area */
        .content {
            padding: 30px;
        }

        /* Cards */
        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .card-header h2 {
            color: #2c3e50;
            font-size: 1.5rem;
        }

        /* Buttons */
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .btn-primary {
            background-color: #3498db;
            color: white;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .btn-success {
            background-color: #27ae60;
            color: white;
        }

        .btn-success:hover {
            background-color: #229954;
        }

        .btn-danger {
            background-color: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .btn-warning {
            background-color: #f39c12;
            color: white;
        }

        .btn-warning:hover {
            background-color: #e67e22;
        }

        .btn-sm {
            padding: 5px 15px;
            font-size: 0.875rem;
        }

        /* Alerts */
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Tables */
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #2c3e50;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Forms */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #2c3e50;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .form-control:focus {
            outline: none;
            border-color: #3498db;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .stat-card.blue {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        }

        .stat-card.green {
            background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
        }

        .stat-card.orange {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        }

        .stat-card h3 {
            font-size: 0.9rem;
            margin-bottom: 10px;
            opacity: 0.9;
        }

        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: bold;
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Bina Adult Care</h2>
                <p>Admin Panel</p>
            </div>
            <ul class="sidebar-menu">
                <li>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="<?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                
                <?php
                    $currentAdmin = \App\Models\UserAdmin::find(session('admin_id'));
                ?>
                
                <?php if($currentAdmin && $currentAdmin->isSuperAdmin()): ?>
                <!-- Super Admin Only -->
                <li>
                    <a href="<?php echo e(route('admin.admins.index')); ?>" class="<?php echo e(request()->routeIs('admin.admins*') || request()->routeIs('admin.activity-logs') ? 'active' : ''); ?>">
                        <i class="fas fa-users-cog"></i> Admin Management
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.settings.index')); ?>" class="<?php echo e(request()->routeIs('admin.settings*') ? 'active' : ''); ?>">
                        <i class="fas fa-cog"></i> Settings
                    </a>
                </li>
                <?php endif; ?>
                
                <li>
                    <a href="<?php echo e(route('admin.services')); ?>" class="<?php echo e(request()->routeIs('admin.services*') ? 'active' : ''); ?>">
                        <i class="fas fa-concierge-bell"></i> Services
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.benefits')); ?>" class="<?php echo e(request()->routeIs('admin.benefits*') ? 'active' : ''); ?>">
                        <i class="fas fa-star"></i> Benefits
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.gallery.index')); ?>" class="<?php echo e(request()->routeIs('admin.gallery*') ? 'active' : ''); ?>">
                        <i class="fas fa-images"></i> Photo Gallery
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.blog.index')); ?>" class="<?php echo e(request()->routeIs('admin.blog*') ? 'active' : ''); ?>">
                        <i class="fas fa-blog"></i> Blog Posts
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.announcements.index')); ?>" class="<?php echo e(request()->routeIs('admin.announcements*') ? 'active' : ''); ?>">
                        <i class="fas fa-bullhorn"></i> Announcements
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.contacts')); ?>" class="<?php echo e(request()->routeIs('admin.contacts*') ? 'active' : ''); ?>">
                        <i class="fas fa-envelope"></i> Contact Messages
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.content')); ?>" class="<?php echo e(request()->routeIs('admin.content*') ? 'active' : ''); ?>">
                        <i class="fas fa-file-alt"></i> Content Management
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <div class="topbar">
                <h1><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h1>
                <div class="user-info">
                    <?php
                        $currentAdmin = \App\Models\UserAdmin::find(session('admin_id'));
                    ?>
                    <?php if($currentAdmin): ?>
                        <span>
                            <?php echo e($currentAdmin->email); ?>

                            <?php if($currentAdmin->isSuperAdmin()): ?>
                                <span style="color: #dc3545; margin-left: 5px;">
                                    <i class="fas fa-crown"></i>
                                </span>
                            <?php endif; ?>
                        </span>
                    <?php endif; ?>
                    <form method="POST" action="<?php echo e(route('admin.logout')); ?>" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="logout-btn">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Content -->
            <div class="content">
                <?php if(session('success')): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <?php if($errors->any()): ?>
                    <div class="alert alert-error">
                        <ul style="margin: 0; padding-left: 20px;">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </main>
    </div>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\DELL\Desktop\My Files\Dev\bina-adult-care-main-master\resources\views/admin/layout.blade.php ENDPATH**/ ?>