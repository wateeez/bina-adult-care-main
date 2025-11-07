<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\AdminActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of announcements
     */
    public function index()
    {
        $announcements = Announcement::orderBy('created_at', 'desc')->get();
        return view('admin.announcements.index', compact('announcements'));
    }

    /**
     * Show the form for creating a new announcement
     */
    public function create()
    {
        return view('admin.announcements.create');
    }

    /**
     * Store a newly created announcement
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:bar,popup',
            'text_content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'link_url' => 'nullable|url',
            'link_text' => 'nullable|string|max:255',
            'background_color' => 'nullable|string|max:7',
            'text_color' => 'nullable|string|max:7',
            'delay_seconds' => 'nullable|integer|min:0|max:60',
            'show_once_per_session' => 'boolean',
            'is_active' => 'boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('announcements', 'public');
        }

        // Set defaults
        $validated['background_color'] = $validated['background_color'] ?? '#4A90E2';
        $validated['text_color'] = $validated['text_color'] ?? '#ffffff';
        $validated['link_text'] = $validated['link_text'] ?? 'Learn More';
        $validated['delay_seconds'] = $validated['delay_seconds'] ?? 3;

        $announcement = Announcement::create($validated);

        // Log activity
        AdminActivityLog::create([
            'user_admin_id' => session('admin_id'),
            'action_type' => 'create',
            'module' => 'announcement',
            'description' => 'Created announcement: ' . $announcement->title,
            'ip_address' => $request->ip()
        ]);

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement created successfully!');
    }

    /**
     * Show the form for editing the specified announcement
     */
    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    /**
     * Update the specified announcement
     */
    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:bar,popup',
            'text_content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'link_url' => 'nullable|url',
            'link_text' => 'nullable|string|max:255',
            'background_color' => 'nullable|string|max:7',
            'text_color' => 'nullable|string|max:7',
            'delay_seconds' => 'nullable|integer|min:0|max:60',
            'show_once_per_session' => 'boolean',
            'is_active' => 'boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($announcement->image_path) {
                Storage::disk('public')->delete($announcement->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('announcements', 'public');
        }

        $announcement->update($validated);

        // Log activity
        AdminActivityLog::create([
            'user_admin_id' => session('admin_id'),
            'action_type' => 'update',
            'module' => 'announcement',
            'description' => 'Updated announcement: ' . $announcement->title,
            'ip_address' => $request->ip()
        ]);

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement updated successfully!');
    }

    /**
     * Remove the specified announcement
     */
    public function destroy(Announcement $announcement)
    {
        $title = $announcement->title;

        // Delete image
        if ($announcement->image_path) {
            Storage::disk('public')->delete($announcement->image_path);
        }

        $announcement->delete();

        // Log activity
        AdminActivityLog::create([
            'user_admin_id' => session('admin_id'),
            'action_type' => 'delete',
            'module' => 'announcement',
            'description' => 'Deleted announcement: ' . $title,
            'ip_address' => request()->ip()
        ]);

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement deleted successfully!');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(Announcement $announcement)
    {
        $announcement->is_active = !$announcement->is_active;
        $announcement->save();

        // Log activity
        AdminActivityLog::create([
            'user_admin_id' => session('admin_id'),
            'action_type' => 'update',
            'module' => 'announcement',
            'description' => ($announcement->is_active ? 'Activated' : 'Deactivated') . ' announcement: ' . $announcement->title,
            'ip_address' => request()->ip()
        ]);

        return response()->json([
            'success' => true,
            'is_active' => $announcement->is_active,
            'message' => $announcement->is_active ? 'Announcement activated!' : 'Announcement deactivated!'
        ]);
    }

    /**
     * Delete announcement image
     */
    public function deleteImage(Announcement $announcement)
    {
        if ($announcement->image_path) {
            Storage::disk('public')->delete($announcement->image_path);
            $announcement->image_path = null;
            $announcement->save();
        }

        return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
    }
}
