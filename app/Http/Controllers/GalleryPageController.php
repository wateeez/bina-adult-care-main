<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryPageController extends Controller
{
    /**
     * Display public gallery page
     */
    public function index()
    {
        $images = Gallery::getActiveImages();
        
        try {
            $contents = \App\Models\Content::all()->keyBy('section');
        } catch (\Exception $e) {
            $contents = collect();
        }
        
        return view('frontend.gallery', compact('images', 'contents'));
    }
}
