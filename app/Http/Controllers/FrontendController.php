<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Contact;

class FrontendController extends Controller
{
    public function index()
    {
        try {
            $contents = \App\Models\Content::all()->keyBy('section');
            $benefits = \App\Models\Benefit::orderBy('order')->get();
        } catch (\Exception $e) {
            $contents = collect();
            $benefits = collect();
        }
        return view('frontend.index', compact('contents', 'benefits'));
    }

    public function services()
    {
        try {
            $services = Service::all();
            $contents = \App\Models\Content::all()->keyBy('section');
        } catch (\Exception $e) {
            $services = collect();
            $contents = collect();
        }
        return view('frontend.services', compact('services', 'contents'));
    }

    public function about()
    {
        try {
            $contents = \App\Models\Content::all()->keyBy('section');
        } catch (\Exception $e) {
            $contents = collect();
        }
        return view('frontend.about', compact('contents'));
    }

    public function contact()
    {
        try {
            $contents = \App\Models\Content::all()->keyBy('section');
            $siteName = $contents['site_name']->value ?? 'Bina Adult Care';
            $siteLogo = isset($contents['site_logo']->background_image) 
                ? asset('storage/' . $contents['site_logo']->background_image) 
                : null;
        } catch (\Exception $e) {
            // Fallback to defaults if database query fails
            $contents = collect();
            $siteName = 'Bina Adult Care';
            $siteLogo = null;
        }
        
        return view('frontend.contact', compact('contents', 'siteName', 'siteLogo'));
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string'
        ]);

        Contact::create($validated);

        return redirect()->back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }
}