<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Bina Adult Care</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/styles.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Website Design Language - Blue Theme */
        :root {
            --primary-color: #4A90E2;
            --secondary-color: #F5E6D3;
            --text-color: #333333;
            --light-bg: #FFFFFF;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
            color: var(--text-color);
        }

        /* Admin Management Styles */
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 3px solid var(--primary-color);
        }

        .admin-header h1 {
            color: var(--text-color);
            font-size: 2rem;
            font-weight: bold;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .admin-header h1 i {
            color: var(--primary-color);
        }

        /* Cards - Matching benefit-card style */
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background: var(--primary-color);
            color: white;
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: none;
        }

        .card-header h3 {
            margin: 0;
            font-size: 1.3rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-header p {
            margin: 0.25rem 0 0 0;
            opacity: 0.95;
            font-size: 0.9rem;
        }

        .card-body {
            padding: 2rem;
        }

        /* Buttons - Matching website button style */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.8rem 2rem;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 30px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: #3a7bc8;
        }

        .btn-secondary {
            background-color: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
        }

        .btn-secondary:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #333;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .btn-sm {
            padding: 0.5rem 1.2rem;
            font-size: 0.85rem;
        }

        .btn-link {
            background: none;
            color: var(--primary-color);
            box-shadow: none;
            padding: 0.4rem 0.8rem;
            border-radius: 5px;
        }

        .btn-link:hover {
            background: rgba(74, 144, 226, 0.1);
            transform: none;
        }

        /* Tables */
        .admin-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .admin-table thead {
            background-color: var(--secondary-color);
        }

        .admin-table thead th {
            padding: 1rem 1.5rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-color);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 2px solid var(--primary-color);
        }

        .admin-table tbody td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e9ecef;
            color: var(--text-color);
            font-size: 0.95rem;
        }

        .admin-table tbody tr {
            transition: background-color 0.2s ease;
        }

        .admin-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .admin-table tbody tr:last-child td {
            border-bottom: none;
        }

        .table-actions {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        /* Alerts - Matching website style */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.95rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .alert i {
            font-size: 1.25rem;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .alert-danger ul {
            margin: 0;
            padding-left: 1.5rem;
        }

        /* Forms */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--text-color);
            font-size: 0.95rem;
        }

        .form-control {
            width: 100%;
            padding: 0.8rem 1rem;
            font-size: 0.95rem;
            font-family: 'Arial', sans-serif;
            border: 2px solid #dee2e6;
            border-radius: 10px;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 0.25rem;
            display: block;
        }

        .form-text {
            color: #6c757d;
            font-size: 0.85rem;
            margin-top: 0.25rem;
            display: block;
        }

        select.form-control {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.4rem 0.9rem;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-success {
            background: #d4edda;
            color: #155724;
        }

        .badge-info {
            background: #d1ecf1;
            color: #0c5460;
        }

        .badge-secondary {
            background: #e2e3e5;
            color: #383d41;
        }

        .text-center {
            text-align: center;
        }

        .text-muted {
            color: #6c757d;
        }

        /* Dashboard Styles */
        .dashboard-header {
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-bottom: 3px solid var(--primary-color);
        }

        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: #fff;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .dashboard-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .admin-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .table-actions {
                flex-direction: column;
            }

            .admin-table {
                font-size: 0.875rem;
            }

            .admin-table thead th,
            .admin-table tbody td {
                padding: 0.75rem 1rem;
            }
        }
    </style>
</head>
<body style="background: #f8f9fa; font-family: 'Arial', sans-serif;">
    <!-- Admin Navigation (scoped classes to avoid frontend CSS collisions) -->
    <nav class="admin-navbar" style="background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 2000;">
        <div class="admin-nav-container" style="max-width: 1400px; margin: 0 auto; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center;">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="logo" style="font-size: 1.5rem; font-weight: bold; color: #4A90E2; text-decoration: none;">
                <i class="fas fa-shield-alt"></i> Bina Admin
            </a>
            <div class="admin-nav-links" style="display: flex; gap: 2rem; align-items: center;">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="<?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>" style="color: <?php echo e(request()->routeIs('admin.dashboard') ? '#4A90E2' : '#333333'); ?>; text-decoration: none; font-weight: 500; transition: color 0.3s;">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="<?php echo e(route('admin.services')); ?>" class="<?php echo e(request()->routeIs('admin.services*') ? 'active' : ''); ?>" style="color: <?php echo e(request()->routeIs('admin.services*') ? '#4A90E2' : '#333333'); ?>; text-decoration: none; font-weight: 500; transition: color 0.3s;">
                    <i class="fas fa-concierge-bell"></i> Services
                </a>
                <a href="<?php echo e(route('admin.contacts')); ?>" class="<?php echo e(request()->routeIs('admin.contacts*') ? 'active' : ''); ?>" style="color: <?php echo e(request()->routeIs('admin.contacts*') ? '#4A90E2' : '#333333'); ?>; text-decoration: none; font-weight: 500; transition: color 0.3s;">
                    <i class="fas fa-envelope"></i> Contacts
                </a>
                <a href="<?php echo e(route('admin.content')); ?>" class="<?php echo e(request()->routeIs('admin.content*') ? 'active' : ''); ?>" style="color: <?php echo e(request()->routeIs('admin.content*') ? '#4A90E2' : '#333333'); ?>; text-decoration: none; font-weight: 500; transition: color 0.3s;">
                    <i class="fas fa-file-alt"></i> Content
                </a>
                <a href="<?php echo e(route('admin.gallery.index')); ?>" class="<?php echo e(request()->routeIs('admin.gallery*') ? 'active' : ''); ?>" style="color: <?php echo e(request()->routeIs('admin.gallery*') ? '#4A90E2' : '#333333'); ?>; text-decoration: none; font-weight: 500; transition: color 0.3s;">
                    <i class="fas fa-images"></i> Gallery
                </a>
                <a href="<?php echo e(route('admin.blog.index')); ?>" class="<?php echo e(request()->routeIs('admin.blog*') ? 'active' : ''); ?>" style="color: <?php echo e(request()->routeIs('admin.blog*') ? '#4A90E2' : '#333333'); ?>; text-decoration: none; font-weight: 500; transition: color 0.3s;">
                    <i class="fas fa-blog"></i> Blog
                </a>
                <a href="<?php echo e(route('admin.announcements.index')); ?>" class="<?php echo e(request()->routeIs('admin.announcements*') ? 'active' : ''); ?>" style="color: <?php echo e(request()->routeIs('admin.announcements*') ? '#4A90E2' : '#333333'); ?>; text-decoration: none; font-weight: 500; transition: color 0.3s;">
                    <i class="fas fa-bullhorn"></i> Announcements
                </a>
                <?php
                    $currentAdmin = \App\Models\UserAdmin::find(session('admin_id'));
                ?>
                <?php if($currentAdmin && $currentAdmin->isSuperAdmin()): ?>
                <a href="<?php echo e(route('admin.admins.index')); ?>" class="<?php echo e(request()->routeIs('admin.admins*') || request()->routeIs('admin.activity-logs') ? 'active' : ''); ?>" style="color: <?php echo e(request()->routeIs('admin.admins*') || request()->routeIs('admin.activity-logs') ? '#4A90E2' : '#333333'); ?>; text-decoration: none; font-weight: 500; transition: color 0.3s;">
                    <i class="fas fa-users-cog"></i> Admins
                </a>
                <a href="<?php echo e(route('admin.settings.index')); ?>" class="<?php echo e(request()->routeIs('admin.settings*') ? 'active' : ''); ?>" style="color: <?php echo e(request()->routeIs('admin.settings*') ? '#4A90E2' : '#333333'); ?>; text-decoration: none; font-weight: 500; transition: color 0.3s;">
                    <i class="fas fa-cog"></i> Settings
                </a>
                <?php endif; ?>
                <form action="<?php echo e(route('admin.logout')); ?>" method="POST" style="margin: 0;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-link" style="color: #dc3545;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="admin-content" style="max-width: 1400px; margin: 0 auto; padding: 2rem;">
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

        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <script src="<?php echo e(asset('js/admin.js')); ?>"></script>
    <style>
        /* Admin navbar isolation to prevent frontend CSS from affecting it */
        .admin-navbar {
            position: sticky;
            top: 0;
            width: 100%;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            z-index: 2000; /* above frontend announcement bar if included */
        }
        .admin-nav-container a {
            line-height: 1.2;
        }
        /* Ensure admin links are always visible on mobile (avoid .nav-links rules) */
        .admin-nav-links {
            display: flex !important;
            flex-wrap: wrap;
            gap: 1rem;
        }
        @media (max-width: 968px) {
            .admin-nav-container { padding: 0.75rem 1rem !important; }
            .admin-nav-links { gap: 0.75rem !important; }
        }
    </style>
</body>
</html><?php /**PATH C:\Users\DELL\Desktop\My Files\Dev\bina-adult-care-main-master\resources\views/admin/layouts/app.blade.php ENDPATH**/ ?>