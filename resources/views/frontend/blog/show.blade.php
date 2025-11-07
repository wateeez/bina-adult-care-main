<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $blog->meta_title }} - {{ \App\Models\SiteSetting::getSiteName() }}</title>
    <meta name="description" content="{{ $blog->meta_description }}">
    @if($blog->meta_keywords)
        <meta name="keywords" content="{{ $blog->meta_keywords }}">
    @endif
    <meta name="author" content="{{ $blog->author_name }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ $blog->url }}">
    <meta property="og:title" content="{{ $blog->meta_title }}">
    <meta property="og:description" content="{{ $blog->meta_description }}">
    @if($blog->header_image)
        <meta property="og:image" content="{{ $blog->header_image_url }}">
    @endif
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ $blog->url }}">
    <meta property="twitter:title" content="{{ $blog->meta_title }}">
    <meta property="twitter:description" content="{{ $blog->meta_description }}">
    @if($blog->header_image)
        <meta property="twitter:image" content="{{ $blog->header_image_url }}">
    @endif
    
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
            line-height: 1.8;
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

        /* Header Image */
        .blog-header {
            position: relative;
            height: 400px;
            overflow: hidden;
            margin-bottom: 3rem;
        }

        .blog-header img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .blog-header-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            padding: 3rem 0 2rem;
            color: white;
        }

        .blog-header-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        /* Blog Content */
        .blog-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 2rem 4rem;
        }

        .blog-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            padding: 1.5rem 0;
            border-bottom: 2px solid #4A90E2;
            margin-bottom: 2rem;
            color: #666;
        }

        .blog-meta span {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .blog-meta i {
            color: #4A90E2;
        }

        .blog-content {
            background: white;
            padding: 3rem;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 3rem;
        }

        .blog-content p {
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
        }

        .blog-content h2, .blog-content h3 {
            color: #4A90E2;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }

        .blog-content ul, .blog-content ol {
            margin-bottom: 1.5rem;
            padding-left: 2rem;
        }

        .blog-content li {
            margin-bottom: 0.5rem;
        }

        .paragraph-image {
            margin: 2rem 0;
            text-align: center;
        }

        .paragraph-image img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }

        .paragraph-image-caption {
            margin-top: 0.75rem;
            font-style: italic;
            color: #666;
            font-size: 0.95rem;
        }

        /* Related Posts */
        .related-posts {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .related-posts h3 {
            color: #4A90E2;
            margin-bottom: 1.5rem;
        }

        .related-post {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #eee;
        }

        .related-post:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .related-post img {
            width: 120px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }

        .related-post-content h4 {
            margin-bottom: 0.5rem;
        }

        .related-post-content h4 a {
            color: #333;
            text-decoration: none;
        }

        .related-post-content h4 a:hover {
            color: #4A90E2;
        }

        .related-post-meta {
            font-size: 0.85rem;
            color: #999;
        }

        /* Back to Blog */
        .back-to-blog {
            display: inline-block;
            margin-bottom: 2rem;
            color: #4A90E2;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .back-to-blog:hover {
            color: #357ABD;
        }

        /* Footer */
        footer {
            background-color: #4A90E2;
            color: white;
            text-align: center;
            padding: 2rem 0;
            margin-top: 4rem;
        }

        /* Mobile */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .blog-header {
                height: 300px;
            }

            .blog-header-title {
                font-size: 2rem;
            }

            .blog-container {
                padding: 0 1rem 3rem;
            }

            .blog-content {
                padding: 2rem 1.5rem;
            }

            .blog-meta {
                gap: 1rem;
            }

            .related-post {
                flex-direction: column;
            }

            .related-post img {
                width: 100%;
                height: 200px;
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
                <li><a href="/blog">Blog</a></li>
                <li><a href="/contact.php">Contact</a></li>
            </ul>
        </div>
    </nav>

    <!-- Header Image -->
    @if($blog->header_image)
        <div class="blog-header">
            <img src="{{ $blog->header_image_url }}" alt="{{ $blog->title }}">
            <div class="blog-header-overlay">
                <div class="container">
                    <h1 class="blog-header-title">{{ $blog->title }}</h1>
                </div>
            </div>
        </div>
    @else
        <div class="blog-header" style="background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%); display: flex; align-items: center;">
            <div class="container">
                <h1 class="blog-header-title" style="color: white;">{{ $blog->title }}</h1>
            </div>
        </div>
    @endif

    <!-- Blog Content -->
    <div class="blog-container">
        <a href="{{ route('blog.index') }}" class="back-to-blog">
            <i class="fas fa-arrow-left me-2"></i>Back to Blog
        </a>

        <div class="blog-meta">
            <span><i class="fas fa-calendar"></i> {{ $blog->published_date }}</span>
            <span><i class="fas fa-user"></i> {{ $blog->author_name }}</span>
            <span><i class="fas fa-clock"></i> {{ $blog->reading_time }}</span>
            <span><i class="fas fa-eye"></i> {{ $blog->view_count }} views</span>
        </div>

        <article class="blog-content">
            @php
                $paragraphs = explode("\n\n", $blog->content);
                $paragraphNumber = 0;
            @endphp

            @foreach($paragraphs as $index => $paragraph)
                @if(trim($paragraph))
                    @php $paragraphNumber++; @endphp
                    <p>{!! nl2br(e(trim($paragraph))) !!}</p>
                    
                    {{-- Display images for this paragraph --}}
                    @if(isset($paragraphImages[$paragraphNumber]) && $paragraphImages[$paragraphNumber]->count() > 0)
                        @foreach($paragraphImages[$paragraphNumber] as $image)
                            <div class="paragraph-image">
                                <img src="{{ $image->image_url }}" alt="{{ $image->alt_text ?? $blog->title }}">
                                @if($image->caption)
                                    <div class="paragraph-image-caption">{{ $image->caption }}</div>
                                @endif
                            </div>
                        @endforeach
                    @endif
                @endif
            @endforeach
        </article>

        @if($relatedBlogs->count() > 0)
            <div class="related-posts">
                <h3><i class="fas fa-newspaper me-2"></i>Related Posts</h3>
                @foreach($relatedBlogs as $related)
                    <div class="related-post">
                        @if($related->header_image)
                            <img src="{{ $related->header_image_url }}" alt="{{ $related->title }}">
                        @else
                            <div style="width: 120px; height: 100px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-image text-muted"></i>
                            </div>
                        @endif
                        <div class="related-post-content">
                            <h4><a href="{{ $related->url }}">{{ $related->title }}</a></h4>
                            <div class="related-post-meta">
                                <i class="fas fa-calendar"></i> {{ $related->published_date }} • 
                                <i class="fas fa-clock"></i> {{ $related->reading_time }}
                            </div>
                            <p>{{ Str::limit($related->excerpt, 100) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
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
