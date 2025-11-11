<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO Meta Tags -->
    <title>Contact Us - Bina Adult Care | Get in Touch for Care Services</title>
    <meta name="description" content="Contact Bina Adult Care for professional caregiving services. Reach out to discuss your care needs or join our team of dedicated caregivers. We're here to help.">
    <meta name="keywords" content="contact bina adult care, caregiver inquiries, care consultation, employment opportunities, caregiver jobs contact">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph -->
    <meta property="og:title" content="Contact Us - Bina Adult Care">
    <meta property="og:description" content="Get in touch with Bina Adult Care. We're here to answer your questions and discuss your care needs.">
    <meta property="og:url" content="<?php echo e(url('/contact')); ?>">
    <meta property="og:type" content="website">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo e(url('/contact')); ?>">
    
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/styles.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/color-theme.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php echo $__env->make('partials.announcement-bar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('partials.announcement-popup', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="<?php echo e(route('home')); ?>" class="logo" style="display: flex; align-items: center; gap: 0.5rem;">
                <?php if(isset($siteLogo)): ?>
                    <img src="<?php echo e($siteLogo); ?>" alt="<?php echo e($siteName ?? 'Bina Adult Care'); ?>" style="height: 50px; max-width: 200px; object-fit: contain;">
                <?php endif; ?>
                <span><?php echo e($siteName ?? 'Bina Adult Care'); ?></span>
            </a>
            <div class="menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
            <ul class="nav-links">
                <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
                <li><a href="<?php echo e(route('about')); ?>">About Us</a></li>
                <li><a href="<?php echo e(route('services')); ?>">Services</a></li>
                <li><a href="<?php echo e(route('gallery')); ?>">Gallery</a></li>
                <li><a href="<?php echo e(route('blog.index')); ?>">Blog</a></li>
                <li><a href="<?php echo e(route('contact')); ?>" class="active">Contact</a></li>
            </ul>
        </div>
    </nav>

    <style>
        /* Additional styles for Contact page */
        .contact-section {
            padding: 4rem 0;
            margin-top: 60px;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .contact-form {
            background: var(--light-bg);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-color);
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .form-group textarea {
            height: 150px;
            resize: vertical;
        }

        .contact-info {
            background: var(--secondary-color);
            padding: 2rem;
            border-radius: 10px;
        }

        .contact-info-item {
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }

        .contact-info-item i {
            color: var(--primary-color);
            font-size: 1.5rem;
            margin-right: 1rem;
        }

        .map-container {
            height: 300px;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 2rem;
        }

        .alert {
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
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
                <li><a href="<?php echo e(route('services')); ?>">Services</a></li>
                <li><a href="<?php echo e(route('gallery')); ?>">Gallery</a></li>
                <li><a href="<?php echo e(route('blog.index')); ?>">Blog</a></li>
                <li><a href="<?php echo e(route('contact')); ?>" class="active">Contact</a></li>
            </ul>
        </div>
    </nav>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <h1><?php echo e($contents['contact_hero']->content ?? 'Get in Touch'); ?></h1>
            <p><?php echo e($contents['contact_subtitle']->content ?? 'We\'re here to answer your questions and discuss your care needs.'); ?></p>
            
            <div class="contact-grid">
                <div class="contact-form">
                    <h2>Send us a Message</h2>
                    
                    <?php if(session('success')): ?>
                        <div class="alert alert-success">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-error">
                            <ul style="margin: 0; padding-left: 1.5rem;">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form id="contactForm" method="POST" action="<?php echo e(route('contact.submit')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" value="<?php echo e(old('name')); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="tel" id="phone" name="phone" value="<?php echo e(old('phone')); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" required><?php echo e(old('message')); ?></textarea>
                        </div>
                        <button type="submit" class="btn primary">Send Message</button>
                    </form>
                </div>

                <div class="contact-info">
                    <h2>Contact Information</h2>
                    <div class="contact-info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h3>Address</h3>
                            <p><?php echo nl2br(e($contents['contact_address']->content ?? '123 Care Street, Suite 100<br>City, State 12345')); ?></p>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <h3>Phone</h3>
                            <p><?php echo e($contents['contact_phone']->content ?? '(555) 123-4567'); ?></p>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h3>Email</h3>
                            <p><?php echo e($contents['contact_email']->content ?? 'info@binaadultcare.com'); ?></p>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <h3>Hours</h3>
                            <p><?php echo nl2br(e($contents['contact_hours']->content ?? 'Monday - Friday: 9:00 AM - 6:00 PM<br>Saturday: 10:00 AM - 4:00 PM<br>Sunday: Closed')); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Map -->
            <div class="map-container">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.1!2d-73.9!3d40.7!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zM40zMCcwMC4wIk4gNzPCsDU0JzAwLjAiVw!5e0!3m2!1sen!2sus!4v1635959561234!5m2!1sen!2sus"
                    width="100%"
                    height="100%"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy">
                </iframe>
            </div>
        </div>
    </section>

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
<?php /**PATH C:\Users\DELL\Desktop\My Files\Dev\bina-adult-care-main-master\resources\views/frontend/contact.blade.php ENDPATH**/ ?>