<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\AdminActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteSettingsController extends Controller
{
    /**
     * Show site settings form
     */
    public function index()
    {
        $logo = SiteSetting::get('site_logo');
        $siteName = SiteSetting::get('site_name', 'Bina Adult Care');
        
        return view('admin.settings.index', compact('logo', 'siteName'));
    }

    /**
     * Update site logo
     */
    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            // Delete old logo if exists
            $oldLogo = SiteSetting::get('site_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            // Store new logo
            $logoPath = $request->file('logo')->store('logos', 'public');
            
            // Update setting
            SiteSetting::set('site_logo', $logoPath);

            // Log activity
            AdminActivityLog::create([
                'user_admin_id' => session('admin_id'),
                'action_type' => 'update',
                'module' => 'settings',
                'action' => 'update_logo',
                'description' => 'Updated site logo',
                'ip_address' => $request->ip(),
            ]);

            return redirect()->route('admin.settings.index')
                ->with('success', 'Logo updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update logo: ' . $e->getMessage());
        }
    }

    /**
     * Remove site logo
     */
    public function removeLogo(Request $request)
    {
        try {
            $oldLogo = SiteSetting::get('site_logo');
            
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            SiteSetting::set('site_logo', null);

            // Log activity
            AdminActivityLog::create([
                'user_admin_id' => session('admin_id'),
                'action_type' => 'delete',
                'module' => 'settings',
                'action' => 'remove_logo',
                'description' => 'Removed site logo',
                'ip_address' => $request->ip(),
            ]);

            return redirect()->route('admin.settings.index')
                ->with('success', 'Logo removed successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to remove logo: ' . $e->getMessage());
        }
    }

    /**
     * Update site name
     */
    public function updateSiteName(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
        ]);

        try {
            SiteSetting::set('site_name', $request->site_name);

            // Log activity
            AdminActivityLog::create([
                'user_admin_id' => session('admin_id'),
                'action_type' => 'update',
                'module' => 'settings',
                'action' => 'update_site_name',
                'description' => 'Updated site name to: ' . $request->site_name,
                'ip_address' => $request->ip(),
            ]);

            return redirect()->route('admin.settings.index')
                ->with('success', 'Site name updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update site name: ' . $e->getMessage());
        }
    }
}
