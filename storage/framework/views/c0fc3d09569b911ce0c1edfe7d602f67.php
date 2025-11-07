<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Gallery - <?php echo e(\App\Models\SiteSetting::getSiteName()); ?></title>
    <link rel="stylesheet" href="<?php echo e(asset('css/styles.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/color-theme.css')); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox@3.2.0/dist/css/glightbox.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #F5E6D3;
            color: #333;
        }

        /* Navigation */
        nav {
            background-color: #4A90E2;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        nav .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: white;
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .nav-logo img {
            height: 50px;
            width: auto;
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 2rem;
            margin: 0;
        }

        nav a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
            font-weight: 500;
        }

        nav a:hover {
            color: #F5E6D3;
        }

        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%);
            color: white;
            padding: 4rem 0;
            text-align: center;
            margin-bottom: 3rem;
        }

        .page-header h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .page-header p {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        /* Gallery Grid */
        .gallery-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem 4rem;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            background: white;
        }

        .gallery-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        .gallery-image-wrapper {
            position: relative;
            overflow: hidden;
            height: 300px;
        }

        .gallery-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .gallery-item:hover .gallery-image {
            transform: scale(1.1);
        }

        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(74, 144, 226, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }

        .gallery-overlay i {
            font-size: 3rem;
            color: white;
        }

        .gallery-info {
            padding: 1.5rem;
        }

        .gallery-info h3 {
            font-size: 1.25rem;
            color: #4A90E2;
            margin-bottom: 0.5rem;
        }

        .gallery-info p {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-state i {
            font-size: 5rem;
            color: #4A90E2;
            margin-bottom: 1.5rem;
            opacity: 0.5;
        }

        .empty-state h2 {
            color: #4A90E2;
            margin-bottom: 1rem;
        }

        .empty-state p {
            color: #666;
            font-size: 1.1rem;
        }

        /* Footer */
        footer {
            background-color: #4A90E2;
            color: white;
            text-align: center;
            padding: 2rem 0;
            margin-top: 4rem;
        }

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2rem;
            }

            .gallery-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1.5rem;
            }

            nav ul {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: #4A90E2;
                flex-direction: column;
                padding: 1rem;
                gap: 1rem;
            }

            nav ul.active {
                display: flex;
            }

            .mobile-menu-toggle {
                display: block;
            }
        }

        @media (max-width: 576px) {
            .gallery-grid {
                grid-template-columns: 1fr;
            }

            .gallery-container {
                padding: 0 1rem 3rem;
            }
        }
    </style>
</head>
<body>
    <?php echo $__env->make('partials.announcement-bar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('partials.announcement-popup', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <!-- Navigation -->
    <nav>
        <div class="container">
            <a href="/" class="nav-logo">
                <?php if(\App\Models\SiteSetting::getLogo()): ?>
                    <img src="<?php echo e(\App\Models\SiteSetting::getLogo()); ?>" alt="<?php echo e(\App\Models\SiteSetting::getSiteName()); ?>">
                <?php endif; ?>
                <span><?php echo e(\App\Models\SiteSetting::getSiteName()); ?></span>
            </a>
            <button class="mobile-menu-toggle" onclick="toggleMenu()">
                <i class="fas fa-bars"></i>
            </button>
            <ul id="navMenu">
                <li><a href="/">Home</a></li>
                <li><a href="/about.php">About</a></li>
                <li><a href="/services.php">Services</a></li>
                <li><a href="/gallery" style="color: #F5E6D3;">Gallery</a></li>
                <li><a href="/blog">Blog</a></li>
                <li><a href="/contact.php">Contact</a></li>
            </ul>
        </div>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <h1><i class="fas fa-images me-3"></i>Photo Gallery</h1>
            <p>Explore our collection of memorable moments</p>
        </div>
    </div>

    <!-- Gallery Grid -->
    <div class="gallery-container">
        <?php if($images->count() > 0): ?>
            <div class="gallery-grid">
                <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="gallery-item">
                        <a href="<?php echo e($image->image_url); ?>" class="glightbox" data-gallery="gallery" 
                           data-title="<?php echo e($image->title); ?>" 
                           data-description="<?php echo e($image->description); ?>">
                            <div class="gallery-image-wrapper">
                                <img src="<?php echo e($image->image_url); ?>" alt="<?php echo e($image->title ?? 'Gallery Image'); ?>" class="gallery-image">
                                <div class="gallery-overlay">
                                    <i class="fas fa-search-plus"></i>
                                </div>
                            </div>
                        </a>
                        <?php if($image->title || $image->description): ?>
                            <div class="gallery-info">
                                <?php if($image->title): ?>
                                    <h3><?php echo e($image->title); ?></h3>
                                <?php endif; ?>
                                <?php if($image->description): ?>
                                    <p><?php echo e($image->description); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-images"></i>
                <h2>No Images Yet</h2>
                <p>The gallery is currently empty. Check back soon for updates!</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; <?php echo e(date('Y')); ?> <?php echo e(\App\Models\SiteSetting::getSiteName()); ?>. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/glightbox@3.2.0/dist/js/glightbox.min.js"></script>
    <script>
        // Initialize GLightbox
        const lightbox = GLightbox({
            touchNavigation: true,
            loop: true,
            autoplayVideos: true,
            closeButton: true,
            zoomable: true,
            draggable: true
        });

        // Mobile menu toggle
        function toggleMenu() {
            const menu = document.getElementById('navMenu');
            menu.classList.toggle('active');
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('navMenu');
            const toggle = document.querySelector('.mobile-menu-toggle');
            
            if (!menu.contains(event.target) && !toggle.contains(event.target)) {
                menu.classList.remove('active');
            }
        });
    </script>
</body>
</html>
<?php /**PATH C:\Users\DELL\Desktop\My Files\Dev\bina-adult-care-main-master\resources\views/frontend/gallery.blade.php ENDPATH**/ ?>