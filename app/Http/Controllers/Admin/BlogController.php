<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogParagraphImage;
use App\Models\AdminActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of blogs
     */
    public function index()
    {
        $blogs = Blog::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new blog
     */
    public function create()
    {
        return view('admin.blog.create');
    }

    /**
     * Store a newly created blog
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'header_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'author_name' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'is_published' => 'boolean'
        ]);

        // Generate slug
        $validated['slug'] = Blog::generateSlug($validated['title']);

        // Handle header image upload
        if ($request->hasFile('header_image')) {
            $validated['header_image'] = $request->file('header_image')->store('blog/headers', 'public');
        }

        // Set published_at if publishing
        if ($request->is_published) {
            $validated['published_at'] = now();
        }

        $blog = Blog::create($validated);

        // Handle paragraph images
        if ($request->has('paragraph_images')) {
            $this->handleParagraphImages($blog, $request->file('paragraph_images'), $request->input('paragraph_numbers'), $request->input('image_captions'), $request->input('image_alt_texts'));
        }

        // Log activity
        AdminActivityLog::create([
            'user_admin_id' => session('admin_id'),
            'action_type' => 'create',
            'module' => 'blog',
            'description' => 'Created blog post: ' . $blog->title,
            'ip_address' => $request->ip()
        ]);

        return redirect()->route('admin.blog.index')->with('success', 'Blog post created successfully!');
    }

    /**
     * Show the form for editing the specified blog
     */
    public function edit(Blog $blog)
    {
        $paragraphImages = $blog->paragraphImages()->orderBy('paragraph_number')->orderBy('order')->get();
        return view('admin.blog.edit', compact('blog', 'paragraphImages'));
    }

    /**
     * Update the specified blog
     */
    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'header_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'author_name' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'is_published' => 'boolean'
        ]);

        // Regenerate slug if title changed
        if ($validated['title'] !== $blog->title) {
            $validated['slug'] = Blog::generateSlug($validated['title'], $blog->id);
        }

        // Handle header image upload
        if ($request->hasFile('header_image')) {
            // Delete old image
            if ($blog->header_image) {
                Storage::disk('public')->delete($blog->header_image);
            }
            $validated['header_image'] = $request->file('header_image')->store('blog/headers', 'public');
        }

        // Set/unset published_at
        if ($request->is_published && !$blog->published_at) {
            $validated['published_at'] = now();
        } elseif (!$request->is_published) {
            $validated['published_at'] = null;
        }

        $blog->update($validated);

        // Handle paragraph images
        if ($request->has('paragraph_images')) {
            $this->handleParagraphImages($blog, $request->file('paragraph_images'), $request->input('paragraph_numbers'), $request->input('image_captions'), $request->input('image_alt_texts'));
        }

        // Log activity
        AdminActivityLog::create([
            'user_admin_id' => session('admin_id'),
            'action_type' => 'update',
            'module' => 'blog',
            'description' => 'Updated blog post: ' . $blog->title,
            'ip_address' => $request->ip()
        ]);

        return redirect()->route('admin.blog.index')->with('success', 'Blog post updated successfully!');
    }

    /**
     * Remove the specified blog
     */
    public function destroy(Blog $blog)
    {
        $title = $blog->title;

        // Delete header image
        if ($blog->header_image) {
            Storage::disk('public')->delete($blog->header_image);
        }

        // Delete paragraph images
        foreach ($blog->paragraphImages as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $blog->delete();

        // Log activity
        AdminActivityLog::create([
            'user_admin_id' => session('admin_id'),
            'action_type' => 'delete',
            'module' => 'blog',
            'description' => 'Deleted blog post: ' . $title,
            'ip_address' => request()->ip()
        ]);

        return redirect()->route('admin.blog.index')->with('success', 'Blog post deleted successfully!');
    }

    /**
     * Delete a paragraph image
     */
    public function deleteParagraphImage(BlogParagraphImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
    }

    /**
     * Toggle publish status
     */
    public function togglePublish(Blog $blog)
    {
        $blog->is_published = !$blog->is_published;
        $blog->published_at = $blog->is_published ? now() : null;
        $blog->save();

        // Log activity
        AdminActivityLog::create([
            'user_admin_id' => session('admin_id'),
            'action_type' => 'update',
            'module' => 'blog',
            'description' => ($blog->is_published ? 'Published' : 'Unpublished') . ' blog post: ' . $blog->title,
            'ip_address' => request()->ip()
        ]);

        return response()->json([
            'success' => true,
            'is_published' => $blog->is_published,
            'message' => $blog->is_published ? 'Blog published!' : 'Blog unpublished!'
        ]);
    }

    /**
     * Handle paragraph images upload
     */
    private function handleParagraphImages($blog, $images, $paragraphNumbers, $captions, $altTexts)
    {
        if (!$images) {
            return;
        }

        foreach ($images as $index => $image) {
            if ($image && $image->isValid()) {
                $path = $image->store('blog/paragraphs', 'public');
                
                BlogParagraphImage::create([
                    'blog_id' => $blog->id,
                    'image_path' => $path,
                    'paragraph_number' => $paragraphNumbers[$index] ?? 1,
                    'caption' => $captions[$index] ?? null,
                    'alt_text' => $altTexts[$index] ?? null,
                    'order' => 0
                ]);
            }
        }
    }
}
