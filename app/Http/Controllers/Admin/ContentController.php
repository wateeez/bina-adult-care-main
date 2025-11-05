<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index()
    {
        $contents = Content::all();
        return view('admin.content.index', compact('contents'));
    }

    public function update(Request $request, $section)
    {
        $validated = $request->validate([
            'content' => 'required|string'
        ]);

        $content = Content::where('section', $section)->first();
        if (!$content) {
            $content = new Content();
            $content->section = $section;
        }
        
        $content->content = $validated['content'];
        $content->save();

        return redirect()->route('admin.content')->with('success', 'Content updated successfully');
    }
}