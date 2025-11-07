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
        
        return view('frontend.gallery', compact('images'));
    }
}
