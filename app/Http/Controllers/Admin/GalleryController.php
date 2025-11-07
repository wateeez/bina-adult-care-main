<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\SiteSetting;
use App\Models\AdminActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display gallery management page
     */
    public function index()
    {
        $images = Gallery::orderBy('order', 'asc')->orderBy('created_at', 'desc')->get();
        $showOnHomepage = SiteSetting::get('show_gallery_on_homepage', '1') === '1';
        $maxImages = 10;
        $currentCount = $images->count();
        
        return view('admin.gallery.index', compact('images', 'showOnHomepage', 'maxImages', 'currentCount'));
    }

    /**
     * Upload new gallery image
     */
    public function store(Request $request)
    {
        // Check if already at max limit
        if (Gallery::count() >= 10) {
            return redirect()->back()->with('error', 'Maximum 10 images allowed in gallery!');
        }

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        try {
            // Store image
            $imagePath = $request->file('image')->store('gallery', 'public');
            
            // Get next order number
            $maxOrder = Gallery::max('order') ?? 0;
            
            // Create gallery entry
            Gallery::create([
                'image_path' => $imagePath,
                'title' => $request->title,
                'description' => $request->description,
                'order' => $maxOrder + 1,
                'is_active' => true,
            ]);

            // Log activity
            AdminActivityLog::create([
                'user_admin_id' => session('admin_id'),
                'action_type' => 'create',
                'module' => 'gallery',
                'description' => 'Uploaded new gallery image: ' . ($request->title ?? 'Untitled'),
                'ip_address' => $request->ip(),
            ]);

            return redirect()->route('admin.gallery.index')
                ->with('success', 'Image uploaded successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to upload image: ' . $e->getMessage());
        }
    }

    /**
     * Update gallery image details
     */
    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        try {
            $gallery->update([
                'title' => $request->title,
                'description' => $request->description,
                'is_active' => $request->has('is_active'),
            ]);

            // Log activity
            AdminActivityLog::create([
                'user_admin_id' => session('admin_id'),
                'action_type' => 'update',
                'module' => 'gallery',
                'description' => 'Updated gallery image: ' . ($gallery->title ?? 'ID ' . $gallery->id),
                'ip_address' => $request->ip(),
            ]);

            return redirect()->route('admin.gallery.index')
                ->with('success', 'Image updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update image: ' . $e->getMessage());
        }
    }

    /**
     * Delete gallery image
     */
    public function destroy(Gallery $gallery)
    {
        try {
            // Delete image file
            if (Storage::disk('public')->exists($gallery->image_path)) {
                Storage::disk('public')->delete($gallery->image_path);
            }

            $title = $gallery->title ?? 'ID ' . $gallery->id;
            $gallery->delete();

            // Log activity
            AdminActivityLog::create([
                'user_admin_id' => session('admin_id'),
                'action_type' => 'delete',
                'module' => 'gallery',
                'description' => 'Deleted gallery image: ' . $title,
                'ip_address' => request()->ip(),
            ]);

            return redirect()->route('admin.gallery.index')
                ->with('success', 'Image deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete image: ' . $e->getMessage());
        }
    }

    /**
     * Update image order
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'required|integer|exists:galleries,id',
        ]);

        try {
            foreach ($request->order as $index => $id) {
                Gallery::where('id', $id)->update(['order' => $index + 1]);
            }

            // Log activity
            AdminActivityLog::create([
                'user_admin_id' => session('admin_id'),
                'action_type' => 'update',
                'module' => 'gallery',
                'description' => 'Reordered gallery images',
                'ip_address' => $request->ip(),
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Toggle homepage display
     */
    public function toggleHomepage(Request $request)
    {
        $show = $request->input('show', '0');
        
        try {
            SiteSetting::set('show_gallery_on_homepage', $show);

            // Log activity
            AdminActivityLog::create([
                'user_admin_id' => session('admin_id'),
                'action_type' => 'update',
                'module' => 'gallery',
                'description' => ($show === '1' ? 'Enabled' : 'Disabled') . ' gallery on homepage',
                'ip_address' => $request->ip(),
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
