<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    public function index()
    {
        // Ensure we have default content sections
        $defaultSections = ['home_hero', 'about_mission', 'services_intro'];
        
        foreach ($defaultSections as $section) {
            Content::firstOrCreate(
                ['section' => $section],
                ['content' => 'Edit this content section.']
            );
        }
        
        $contents = Content::all();
        return view('admin.content.index', compact('contents'));
    }

    public function update(Request $request, $section)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $content = Content::where('section', $section)->first();
        if (!$content) {
            $content = new Content();
            $content->section = $section;
        }
        
        $content->content = $validated['content'];
        
        // Handle background image
        if ($request->hasFile('background_image')) {
            // Delete old background image if exists
            if ($content->background_image && Storage::disk('public')->exists($content->background_image)) {
                Storage::disk('public')->delete($content->background_image);
            }
            
            $backgroundImagePath = $request->file('background_image')->store('content/backgrounds', 'public');
            $content->background_image = $backgroundImagePath;
        }
        
        $content->save();

        return redirect()->route('admin.content')->with('success', 'Content updated successfully');
    }
}