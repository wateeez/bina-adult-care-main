<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO Meta Tags -->
    <title>Our Services - Bina Adult Care | Comprehensive Caregiving Solutions</title>
    <meta name="description" content="Explore Bina Adult Care's comprehensive caregiving services. Professional home care, personal assistance, and specialized support tailored to your needs.">
    <meta name="keywords" content="caregiving services, home care services, personal care, elder care, professional caregiver services, health support">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph -->
    <meta property="og:title" content="Our Services - Bina Adult Care">
    <meta property="og:description" content="Comprehensive care solutions tailored to your needs. Professional caregiving services you can trust.">
    <meta property="og:url" content="<?php echo e(url('/services')); ?>">
    <meta property="og:type" content="website">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo e(url('/services')); ?>">
    
    <link rel="stylesheet" href="<?php echo e(asset('css/styles.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/color-theme.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Additional styles for Services page */
        .services-hero {
            background: linear-gradient(rgba(74, 144, 226, 0.1), rgba(74, 144, 226, 0.1));
            background-size: cover;
            background-position: center;
            height: 50vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin-top: 60px;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            padding: 4rem 0;
        }

        .service-card {
            background: var(--light-bg);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-5px);
        }

        .service-image {
            height: 200px;
            background-size: cover;
            background-position: center;
        }

        .service-content {
            padding: 1.5rem;
        }

        .service-content h3 {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .no-services {
            text-align: center;
            padding: 3rem;
            grid-column: 1 / -1;
        }
    </style>
</head>
<body>
    <?php echo $__env->make('partials.announcement-bar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('partials.announcement-popup', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="<?php echo e(route('home')); ?>" class="logo" style="display: flex; align-items: center; gap: 0.5rem;">
                <?php if($siteLogo): ?>
                    <img src="<?php echo e($siteLogo); ?>" alt="<?php echo e($siteName); ?>" style="height: 50px; max-width: 200px; object-fit: contain;">
                <?php endif; ?>
                <span><?php echo e($siteName); ?></span>
            </a>
            <div class="menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
            <ul class="nav-links">
                <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
                <li><a href="<?php echo e(route('about')); ?>">About Us</a></li>
                <li><a href="<?php echo e(route('services')); ?>" class="active">Services</a></li>
                <li><a href="<?php echo e(route('gallery')); ?>">Gallery</a></li>
                <li><a href="<?php echo e(route('blog.index')); ?>">Blog</a></li>
                <li><a href="<?php echo e(route('contact')); ?>">Contact</a></li>
            </ul>
        </div>
    </nav>

    <!-- Services Hero Section -->
    <section class="services-hero" <?php if(isset($contents['services_intro']) && $contents['services_intro']->background_image): ?> style="background-image: linear-gradient(rgba(74, 144, 226, 0.1), rgba(74, 144, 226, 0.1)), url('<?php echo e(asset('storage/' . $contents['services_intro']->background_image)); ?>'); background-size: cover; background-position: center;" <?php endif; ?>>
        <div class="hero-content">
            <h1><?php echo e($contents['services_hero']->content ?? 'Our Services'); ?></h1>
            <p><?php echo e($contents['services_subtitle']->content ?? 'Comprehensive care solutions tailored to your needs'); ?></p>
        </div>
    </section>

    <!-- Services Grid -->
    <div class="container">
        <div class="services-grid">
            <?php if($services->isEmpty()): ?>
                <div class="no-services">
                    <p>No services available at the moment.</p>
                </div>
            <?php else: ?>
                <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="service-card">
                        <div class="service-image" style="background-image: url('<?php echo e($service->image ? asset('storage/' . $service->image) : asset('images/default-service.jpg')); ?>');"></div>
                        <div class="service-content">
                            <h3><?php echo e($service->title); ?></h3>
                            <p><?php echo e($service->description); ?></p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Bina Adult Care</h3>
                    <p>Professional caregiving services with a personal touch.</p>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
                        <li><a href="<?php echo e(route('about')); ?>">About Us</a></li>
                        <li><a href="<?php echo e(route('services')); ?>">Services</a></li>
                        <li><a href="<?php echo e(route('contact')); ?>">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Contact Us</h3>
                    <p>Email: <?php echo e($contents['contact_email']->content ?? 'info@binaadultcare.com'); ?></p>
                    <p>Phone: <?php echo e($contents['contact_phone']->content ?? '(555) 123-4567'); ?></p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Bina Adult Care. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="<?php echo e(asset('js/main.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\Users\DELL\Desktop\My Files\Dev\bina-adult-care-main-master\resources\views/frontend/services.blade.php ENDPATH**/ ?>