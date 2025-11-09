<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - {{ \App\Models\SiteSetting::getSiteName() }}</title>
    <meta name="description" content="Read our latest blog posts about adult care, caregiving tips, and industry insights.">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/color-theme.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

        /* Blog Grid */
        .blog-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem 4rem;
        }

        .blog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .blog-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .blog-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        .blog-card-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            background: #f0f0f0;
        }

        .blog-card-content {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .blog-card-meta {
            display: flex;
            gap: 1rem;
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 1rem;
        }

        .blog-card-meta span {
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .blog-card-title {
            font-size: 1.5rem;
            color: #4A90E2;
            margin-bottom: 0.75rem;
            line-height: 1.3;
        }

        .blog-card-title a {
            color: inherit;
            text-decoration: none;
            transition: color 0.3s;
        }

        .blog-card-title a:hover {
            color: #357ABD;
        }

        .blog-card-excerpt {
            color: #666;
            line-height: 1.6;
            margin-bottom: 1rem;
            flex-grow: 1;
        }

        .blog-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #eee;
        }

        .read-more {
            color: #4A90E2;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .read-more:hover {
            color: #357ABD;
        }

        /* Sidebar */
        .sidebar {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .sidebar h3 {
            color: #4A90E2;
            margin-bottom: 1.5rem;
            font-size: 1.25rem;
        }

        .sidebar-post {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }

        .sidebar-post:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .sidebar-post img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }

        .sidebar-post-content h4 {
            font-size: 0.95rem;
            margin-bottom: 0.3rem;
        }

        .sidebar-post-content h4 a {
            color: #333;
            text-decoration: none;
        }

        .sidebar-post-content h4 a:hover {
            color: #4A90E2;
        }

        .sidebar-post-date {
            font-size: 0.8rem;
            color: #999;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 15px;
        }

        .empty-state i {
            font-size: 5rem;
            color: #4A90E2;
            margin-bottom: 1.5rem;
            opacity: 0.5;
        }

        /* Footer */
        footer {
            background-color: #4A90E2;
            color: white;
            text-align: center;
            padding: 2rem 0;
            margin-top: 4rem;
        }

        /* Mobile Menu */
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

            .blog-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .blog-container {
                padding: 0 1rem 3rem;
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
    </style>
</head>
<body>
    @include('partials.announcement-bar')
    @include('partials.announcement-popup')
    
    <!-- Navigation -->
    <nav>
        <div class="container">
            <a href="/" class="nav-logo">
                @if(\App\Models\SiteSetting::getLogo())
                    <img src="{{ \App\Models\SiteSetting::getLogo() }}" alt="{{ \App\Models\SiteSetting::getSiteName() }}">
                @endif
                <span>{{ \App\Models\SiteSetting::getSiteName() }}</span>
            </a>
            <button class="mobile-menu-toggle" onclick="toggleMenu()">
                <i class="fas fa-bars"></i>
            </button>
            <ul id="navMenu">
                <li><a href="/">Home</a></li>
                <li><a href="/about.php">About</a></li>
                <li><a href="/services.php">Services</a></li>
                <li><a href="/gallery">Gallery</a></li>
                <li><a href="/blog" style="color: #F5E6D3;">Blog</a></li>
                <li><a href="{{ route('contact') }}">Contact</a></li>
            </ul>
        </div>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <h1><i class="fas fa-blog me-3"></i>Our Blog</h1>
            <p>Insights, tips, and updates from our caregiving experts</p>
        </div>
    </div>

    <!-- Blog Content -->
    <div class="blog-container">
        <div class="row">
            <div class="col-lg-8">
                @if($blogs->count() > 0)
                    <div class="blog-grid" style="grid-template-columns: 1fr;">
                        @foreach($blogs as $blog)
                            <article class="blog-card">
                                @if($blog->header_image)
                                    <img src="{{ $blog->header_image_url }}" alt="{{ $blog->title }}" class="blog-card-image">
                                @else
                                    <div class="blog-card-image" style="display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%);">
                                        <i class="fas fa-newspaper" style="font-size: 4rem; color: white; opacity: 0.5;"></i>
                                    </div>
                                @endif
                                <div class="blog-card-content">
                                    <div class="blog-card-meta">
                                        <span><i class="fas fa-calendar"></i> {{ $blog->published_date }}</span>
                                        <span><i class="fas fa-user"></i> {{ $blog->author_name }}</span>
                                        <span><i class="fas fa-clock"></i> {{ $blog->reading_time }}</span>
                                    </div>
                                    <h2 class="blog-card-title">
                                        <a href="{{ $blog->url }}">{{ $blog->title }}</a>
                                    </h2>
                                    <p class="blog-card-excerpt">{{ $blog->excerpt ?? Str::limit(strip_tags($blog->content), 150) }}</p>
                                    <div class="blog-card-footer">
                                        <a href="{{ $blog->url }}" class="read-more">
                                            Read More <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                        <span style="color: #999; font-size: 0.85rem;">
                                            <i class="fas fa-eye"></i> {{ $blog->view_count }} views
                                        </span>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        {{ $blogs->links() }}
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-blog"></i>
                        <h2>No Blog Posts Yet</h2>
                        <p>Check back soon for updates and insights!</p>
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                @if($latestBlogs->count() > 0)
                    <div class="sidebar">
                        <h3><i class="fas fa-fire me-2"></i>Latest Posts</h3>
                        @foreach($latestBlogs as $latest)
                            <div class="sidebar-post">
                                @if($latest->header_image)
                                    <img src="{{ $latest->header_image_url }}" alt="{{ $latest->title }}">
                                @else
                                    <div style="width: 80px; height: 80px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                                <div class="sidebar-post-content">
                                    <h4><a href="{{ $latest->url }}">{{ Str::limit($latest->title, 50) }}</a></h4>
                                    <div class="sidebar-post-date">{{ $latest->published_date }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} {{ \App\Models\SiteSetting::getSiteName() }}. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleMenu() {
            document.getElementById('navMenu').classList.toggle('active');
        }

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
