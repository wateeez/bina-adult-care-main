<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentEditorMiddleware
{
    /**
     * Handle an incoming request.
     * Both super admins and content editors can access these routes
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

        // Update last activity
        $admin->updateActivity();

        // Store admin info in request for easy access
        $request->merge(['admin' => $admin]);

        return $next($request);
    }
}
