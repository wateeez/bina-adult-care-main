<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogPageController extends Controller
{
    /**
     * Display a listing of published blogs
     */
    public function index()
    {
        $blogs = Blog::published()->paginate(12);
        $latestBlogs = Blog::published()->limit(5)->get();
        
        return view('frontend.blog.index', compact('blogs', 'latestBlogs'));
    }

    /**
     * Display the specified blog
     */
    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Increment view count
        $blog->incrementViews();

        // Get related blogs (same author or recent)
        $relatedBlogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->limit(3)
            ->get();

        // Get paragraph images grouped by paragraph number
        $paragraphImages = $blog->paragraphImages()
            ->orderBy('paragraph_number')
            ->orderBy('order')
            ->get()
            ->groupBy('paragraph_number');

        return view('frontend.blog.show', compact('blog', 'relatedBlogs', 'paragraphImages'));
    }
}
