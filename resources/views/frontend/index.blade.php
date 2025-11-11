<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO Meta Tags -->
    <title>Bina Adult Care - Professional Caregiving Services | Home Care & Support</title>
    <meta name="description" content="Bina Adult Care provides professional caregiving services operated by experienced caregivers. We offer personalized home care, health support, and comprehensive benefits for our employees.">
    <meta name="keywords" content="adult care, caregiving services, home care, elder care, professional caregivers, health workers, caregiver jobs, bina adult care">
    <meta name="author" content="Bina Adult Care">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="Bina Adult Care - Professional Caregiving Services">
    <meta property="og:description" content="Owned, operated, and managed by caregivers. We look after your best interests with a profound understanding of the challenges caregivers face.">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url('/') }}">
    <meta property="twitter:title" content="Bina Adult Care - Professional Caregiving Services">
    <meta property="twitter:description" content="Owned, operated, and managed by caregivers. Professional home care services with industry-leading benefits.">
    <meta property="twitter:image" content="{{ asset('images/og-image.jpg') }}">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url('/') }}">
    
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/color-theme.css') }}">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
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
                <li><a href="{{ route('home') }}" class="active">Home</a></li>
                <li><a href="{{ route('about') }}">About Us</a></li>
                <li><a href="{{ route('services') }}">Services</a></li>
                <li><a href="{{ route('gallery') }}">Gallery</a></li>
                <li><a href="{{ route('blog.index') }}">Blog</a></li>
                <li><a href="{{ route('contact') }}">Contact</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" @if(isset($contents['home_hero']) && $contents['home_hero']->background_image) style="background-image: url('{{ asset('storage/' . $contents['home_hero']->background_image) }}');" @endif>
        <div class="hero-content">
            <h1>{{ $contents['home_hero_title']->content ?? 'Owned, Operated, and Managed by Caregivers.' }}</h1>
            <p>{{ $contents['home_hero_subtitle']->content ?? 'We look after your best interests, with a profound understanding of the challenges caregivers face firsthand.' }}</p>
            <div class="hero-buttons">
                <a href="{{ route('contact') }}" class="btn primary">Join Our Team</a>
                <a href="{{ route('about') }}" class="btn secondary">Learn More</a>
            </div>
        </div>
    </section>

    <!-- Program Section -->
    <section class="program">
        <div class="container">
            <h2>{{ $contents['home_program_title']->content ?? 'Bina Adult Care: The Human Service and Home Health Workers Loan Repayment Program' }}</h2>
            <p>{{ $contents['home_program_text']->content ?? 'Our employees are eligible through the Bina Adult care Program.' }}</p>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="benefits">
        <div class="container">
            <h2>Our Benefits</h2>
            <div class="benefits-grid">
                @forelse($benefits as $benefit)
                <div class="benefit-card">
                    <i class="{{ $benefit->icon }}"></i>
                    <h3>{{ $benefit->title }}</h3>
                    @if($benefit->description)
                        <p>{{ $benefit->description }}</p>
                    @endif
                </div>
                @empty
                <div class="benefit-card">
                    <i class="fas fa-certificate"></i>
                    <h3>Certified Training and Education</h3>
                </div>
                <div class="benefit-card">
                    <i class="fas fa-dollar-sign"></i>
                    <h3>Industry-Leading Wages</h3>
                </div>
                <div class="benefit-card">
                    <i class="fas fa-piggy-bank"></i>
                    <h3>401(k) Plan</h3>
                </div>
                <div class="benefit-card">
                    <i class="fas fa-clock"></i>
                    <h3>Flexible Hours</h3>
                </div>
                <div class="benefit-card">
                    <i class="fas fa-award"></i>
                    <h3>Employee Recognition Programs</h3>
                </div>
                <div class="benefit-card">
                    <i class="fas fa-heart"></i>
                    <h3>Health Insurance</h3>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Community Section -->
    <section class="community">
        <div class="container">
            <h2>Join Our Community</h2>
            <p>By choosing us, you're not just selecting a home care provider; you're joining a community of caregivers dedicated to making your life easier.</p>
            <a href="{{ route('contact') }}" class="btn primary">Apply Now</a>
        </div>
    </section>

    <!-- Photo Gallery Section -->
    @php
        $showGallery = \App\Models\Gallery::shouldShowOnHomepage();
        $galleryImages = $showGallery ? \App\Models\Gallery::getActiveImages()->take(6) : collect([]);
    @endphp
    
    @if($showGallery && $galleryImages->count() > 0)
    <section class="gallery-section" style="background: white; padding: 4rem 0;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 3rem;">
                <h2 style="font-size: 2.5rem; color: #2c3e50; margin-bottom: 1rem;">Photo Gallery</h2>
                <p style="font-size: 1.1rem; color: #2c3e50;">Explore our memorable moments</p>
            </div>
            
            <div class="gallery-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem; margin-bottom: 2rem;">
                @foreach($galleryImages as $image)
                    <div class="gallery-item" style="position: relative; overflow: hidden; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s; background: white;">
                        <a href="{{ route('gallery') }}" style="text-decoration: none; color: inherit;">
                            <div style="position: relative; overflow: hidden; height: 250px;">
                                <img src="{{ $image->image_url }}" alt="{{ $image->title ?? 'Gallery Image' }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;">
                                <div class="gallery-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(74, 144, 226, 0.9); display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s;">
                                    <i class="fas fa-search-plus" style="font-size: 2rem; color: white;"></i>
                                </div>
                            </div>
                            @if($image->title)
                                <div style="padding: 1rem;">
                                    <h3 style="font-size: 1.1rem; color: #2c3e50; margin-bottom: 0.5rem;">{{ $image->title }}</h3>
                                    @if($image->description)
                                        <p style="color: #2c3e50; font-size: 0.9rem;">{{ Str::limit($image->description, 80) }}</p>
                                    @endif
                                </div>
                            @endif
                        </a>
                    </div>
                @endforeach
            </div>
            
            <div style="text-align: center;">
                <a href="{{ route('gallery') }}" class="btn primary" style="display: inline-block; padding: 1rem 2rem; background: #4A90E2; color: white; text-decoration: none; border-radius: 30px; font-weight: 600; transition: all 0.3s;">
                    <i class="fas fa-images me-2"></i> View Full Gallery
                </a>
            </div>
        </div>
    </section>
    
    <style>
        .gallery-item:hover {
            transform: translateY(-10px);
        }
        
        .gallery-item:hover img {
            transform: scale(1.1);
        }
        
        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }
        
        @media (max-width: 768px) {
            .gallery-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)) !important;
                gap: 1.5rem !important;
            }
        }
        
        @media (max-width: 576px) {
            .gallery-grid {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
    @endif

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
                    <p>Email: {{ $contents['contact_email']->content ?? 'info@binaadultcare.com' }}</p>
                    <p>Phone: {{ $contents['contact_phone']->content ?? '(555) 123-4567' }}</p>
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
