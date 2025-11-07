<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO Meta Tags -->
    <title>About Us - Bina Adult Care | Our Story & Mission</title>
    <meta name="description" content="Learn about Bina Adult Care - an organization founded and operated by caregivers who understand the challenges you face. Discover our mission, values, and commitment to exceptional care.">
    <meta name="keywords" content="about bina adult care, caregiver story, care mission, values, experienced caregivers, compassionate care">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph -->
    <meta property="og:title" content="About Bina Adult Care - Our Story & Mission">
    <meta property="og:description" content="Founded by caregivers who've lived it. We understand the demands and emotional toll of caregiving firsthand.">
    <meta property="og:url" content="<?php echo e(url('/about')); ?>">
    <meta property="og:type" content="website">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo e(url('/about')); ?>">
    
    <link rel="stylesheet" href="<?php echo e(asset('css/styles.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/color-theme.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Additional styles for About page */
        .about-hero {
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

        .about-content {
            padding: 4rem 0;
        }

        .about-section {
            margin-bottom: 3rem;
        }

        .about-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .value-card {
            background: var(--light-bg);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
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
                <li><a href="<?php echo e(route('about')); ?>" class="active">About Us</a></li>
                <li><a href="<?php echo e(route('services')); ?>">Services</a></li>
                <li><a href="<?php echo e(route('gallery')); ?>">Gallery</a></li>
                <li><a href="<?php echo e(route('blog.index')); ?>">Blog</a></li>
                <li><a href="<?php echo e(route('contact')); ?>">Contact</a></li>
            </ul>
        </div>
    </nav>

    <!-- About Hero Section -->
    <section class="about-hero" <?php if(isset($contents['about_hero']) && $contents['about_hero']->background_image): ?> style="background-image: linear-gradient(rgba(74, 144, 226, 0.1), rgba(74, 144, 226, 0.1)), url('<?php echo e(asset('storage/' . $contents['about_hero']->background_image)); ?>'); background-size: cover; background-position: center;" <?php endif; ?>>
        <div class="hero-content">
            <h1>We Understand Caregiving — Because We've Lived It.</h1>
        </div>
    </section>

    <!-- About Content -->
    <div class="about-content">
        <div class="container">
            <div class="about-section">
                <h2>Our Story</h2>
                <p>As an organization founded and operated by individuals who have walked in your shoes, we intimately comprehend the intricate demands and emotional toll that caregiving can encompass. Our mission is to support, empower, and uplift caregivers with meaningful opportunities and compassionate understanding.</p>
            </div>

            <div class="about-section">
                <h2>Our Mission</h2>
                <p>To provide exceptional care services while creating meaningful career opportunities for passionate caregivers, fostering a community where both care recipients and caregivers thrive.</p>
            </div>

            <div class="about-section">
                <h2>Our Values</h2>
                <div class="about-grid">
                    <div class="value-card">
                        <h3>Compassion</h3>
                        <p>We approach every interaction with genuine care and understanding.</p>
                    </div>
                    <div class="value-card">
                        <h3>Excellence</h3>
                        <p>We strive for the highest standards in care and service delivery.</p>
                    </div>
                    <div class="value-card">
                        <h3>Integrity</h3>
                        <p>We conduct ourselves with honesty and transparency in all we do.</p>
                    </div>
                    <div class="value-card">
                        <h3>Empowerment</h3>
                        <p>We believe in enabling both our caregivers and clients to achieve their best.</p>
                    </div>
                </div>
            </div>
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
                    <p>Email: info@binaadultcare.com</p>
                    <p>Phone: (555) 123-4567</p>
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
<?php /**PATH C:\Users\DELL\Desktop\My Files\Dev\bina-adult-care-main-master\resources\views/frontend/about.blade.php ENDPATH**/ ?>