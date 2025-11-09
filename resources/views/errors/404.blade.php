<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | Bina Adult Care</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/color-theme.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .error-content {
            min-height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 100px 20px 60px;
            background-color: #f8f9fa;
        }

        .error-container {
            text-align: center;
            max-width: 600px;
            width: 100%;
        }

        .error-code {
            font-size: 120px;
            font-weight: bold;
            color: var(--primary-color);
            margin: 0;
            line-height: 1;
        }

        .error-icon {
            font-size: 80px;
            color: var(--primary-color);
            margin-bottom: 20px;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-20px);
            }
            60% {
                transform: translateY(-10px);
            }
        }

        .error-title {
            font-size: 2.5rem;
            color: var(--text-color);
            margin: 20px 0;
        }

        .error-message {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .error-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 40px;
        }

        .helpful-links {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px solid #ddd;
        }

        .helpful-links h3 {
            font-size: 1.3rem;
            color: var(--text-color);
            margin-bottom: 20px;
        }

        .helpful-links ul {
            list-style: none;
            padding: 0;
            display: flex;
            gap: 30px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .helpful-links a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }

        .helpful-links a:hover {
            color: #357abd;
            text-decoration: underline;
        }

        .helpful-links i {
            margin-right: 8px;
        }

        @media (max-width: 768px) {
            .error-code {
                font-size: 80px;
            }

            .error-title {
                font-size: 1.8rem;
            }

            .error-message {
                font-size: 1rem;
            }

            .error-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .helpful-links ul {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    @php
        $contents = \App\Models\Content::all()->keyBy('section');
        $siteName = $contents['site_name']->value ?? 'Bina Adult Care';
        $siteLogo = isset($contents['site_logo']->background_image) 
            ? asset('storage/' . $contents['site_logo']->background_image) 
            : null;
    @endphp

    @include('partials.announcement-bar')
    @include('partials.announcement-popup')
    
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="logo" style="display: flex; align-items: center; gap: 0.5rem;">
                @if($siteLogo)
                    <img src="{{ $siteLogo }}" alt="{{ $siteName }}" style="height: 50px; max-width: 200px; object-fit: contain;">
                @endif
                <span>{{ $siteName }}</span>
            </a>
            <div class="menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
            <ul class="nav-links">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('about') }}">About Us</a></li>
                <li><a href="{{ route('services') }}">Services</a></li>
                <li><a href="{{ route('gallery') }}">Gallery</a></li>
                <li><a href="{{ route('blog.index') }}">Blog</a></li>
                <li><a href="{{ route('contact') }}">Contact</a></li>
            </ul>
        </div>
    </nav>

    <!-- Error Content -->
    <div class="error-content">
        <div class="error-container">
            <div class="error-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h1 class="error-code">404</h1>
            <h2 class="error-title">Oops! Page Not Found</h2>
            <p class="error-message">
                The page you're looking for doesn't exist or has been moved. 
                Don't worry, let's get you back on track!
            </p>
            
            <div class="error-buttons">
                <a href="{{ route('home') }}" class="btn primary">
                    <i class="fas fa-home"></i> Back to Home
                </a>
                <a href="javascript:history.back()" class="btn secondary">
                    <i class="fas fa-arrow-left"></i> Go Back
                </a>
            </div>

            <div class="helpful-links">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a></li>
                    <li><a href="{{ route('about') }}"><i class="fas fa-info-circle"></i> About Us</a></li>
                    <li><a href="{{ route('services') }}"><i class="fas fa-concierge-bell"></i> Services</a></li>
                    <li><a href="{{ route('contact') }}"><i class="fas fa-envelope"></i> Contact</a></li>
                </ul>
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
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="{{ route('services') }}">Services</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
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

    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
