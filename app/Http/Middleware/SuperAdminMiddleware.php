<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     * Only super admins can access routes protected by this middleware
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login')->with('error', 'Please login to access admin panel');
        }

        $admin = \App\Models\UserAdmin::find(session('admin_id'));

        if (!$admin) {
            session()->forget('admin_id');
            return redirect()->route('admin.login')->with('error', 'Admin account not found');
        }

        // Check if account is active
        if (!$admin->is_active) {
            session()->forget('admin_id');
            return redirect()->route('admin.login')->with('error', 'Your account has been deactivated');
        }

        // Check session timeout (30 minutes)
        if ($admin->isSessionExpired()) {
            session()->forget('admin_id');
            return redirect()->route('admin.login')->with('error', 'Session expired due to inactivity');
        }

        // Check if user is super admin
        if (!$admin->isSuperAdmin()) {
            return redirect()->route('admin.dashboard')->with('error', 'Access denied. Super admin privileges required.');
        }

        // Update last activity
        $admin->updateActivity();

        return $next($request);
    }
}
