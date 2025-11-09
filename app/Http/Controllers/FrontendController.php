<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Contact;

class FrontendController extends Controller
{
    protected function getAnnouncementData()
    {
        try {
            $activeBar = \App\Models\Announcement::where('is_active', true)
                ->where('type', 'bar')
                ->first();
            $activePopup = \App\Models\Announcement::where('is_active', true)
                ->where('type', 'popup')
                ->first();
        } catch (\Exception $e) {
            $activeBar = null;
            $activePopup = null;
        }
        
        return compact('activeBar', 'activePopup');
    }
    
    public function index()
    {
        try {
            $contents = \App\Models\Content::all()->keyBy('section');
            $benefits = \App\Models\Benefit::orderBy('order')->get();
        } catch (\Exception $e) {
            $contents = collect();
            $benefits = collect();
        }
        
        $announcements = $this->getAnnouncementData();
        return view('frontend.index', array_merge(compact('contents', 'benefits'), $announcements));
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
        
        $announcements = $this->getAnnouncementData();
        return view('frontend.services', array_merge(compact('services', 'contents'), $announcements));
    }

    public function about()
    {
        try {
            $contents = \App\Models\Content::all()->keyBy('section');
        } catch (\Exception $e) {
            $contents = collect();
        }
        
        $announcements = $this->getAnnouncementData();
        return view('frontend.about', array_merge(compact('contents'), $announcements));
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
        
        $announcements = $this->getAnnouncementData();
        return view('frontend.contact', array_merge(compact('contents', 'siteName', 'siteLogo'), $announcements));
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