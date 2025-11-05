<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - Bina Adult Care</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
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
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="logo">Bina Adult Care</a>
            <div class="menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
            <ul class="nav-links">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('about') }}">About Us</a></li>
                <li><a href="{{ route('services') }}" class="active">Services</a></li>
                <li><a href="{{ route('contact') }}">Contact</a></li>
            </ul>
        </div>
    </nav>

    <!-- Services Hero Section -->
    <section class="services-hero" @if(isset($contents['services_intro']) && $contents['services_intro']->background_image) style="background-image: linear-gradient(rgba(74, 144, 226, 0.1), rgba(74, 144, 226, 0.1)), url('{{ asset('storage/' . $contents['services_intro']->background_image) }}'); background-size: cover; background-position: center;" @endif>
        <div class="hero-content">
            <h1>Our Services</h1>
            <p>Comprehensive care solutions tailored to your needs</p>
        </div>
    </section>

    <!-- Services Grid -->
    <div class="container">
        <div class="services-grid">
            @if($services->isEmpty())
                <div class="no-services">
                    <p>No services available at the moment.</p>
                </div>
            @else
                @foreach($services as $service)
                    <div class="service-card">
                        <div class="service-image" style="background-image: url('{{ $service->image ? asset('storage/' . $service->image) : asset('images/default-service.jpg') }}');"></div>
                        <div class="service-content">
                            <h3>{{ $service->title }}</h3>
                            <p>{{ $service->description }}</p>
                        </div>
                    </div>
                @endforeach
            @endif
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
