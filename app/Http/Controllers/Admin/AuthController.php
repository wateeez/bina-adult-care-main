<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserAdmin;
use App\Models\AdminActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        if (session('admin_id')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    /**
     * Handle login - Email & Password
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $admin = UserAdmin::where('email', $request->email)->first();

        if (!$admin) {
            return back()->with('error', 'Invalid email or password')->withInput();
        }

        if (!$admin->is_active) {
            return back()->with('error', 'Your account has been deactivated. Contact super admin.')->withInput();
        }

        if (!$admin->verifyPassword($request->password)) {
            AdminActivityLog::logActivity(
                $admin->id,
                'login_failed',
                'authentication',
                'Failed login attempt for ' . $admin->email,
                null,
                ['ip' => $request->ip()]
            );
            return back()->with('error', 'Invalid email or password')->withInput();
        }

        // Update last activity
        $admin->updateActivity();

        // Set admin session
        session(['admin_id' => $admin->id]);

        // Log successful login
        AdminActivityLog::logActivity(
            $admin->id,
            'login',
            'authentication',
            'Admin logged in successfully',
            null,
            ['ip' => $request->ip(), 'user_agent' => $request->userAgent()]
        );

        return redirect()->route('admin.dashboard')->with('success', 'Welcome back, ' . $admin->email);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        if (session('admin_id')) {
            $admin = UserAdmin::find(session('admin_id'));
            if ($admin) {
                AdminActivityLog::logActivity(
                    $admin->id,
                    'logout',
                    'authentication',
                    'Admin logged out',
                    null,
                    ['ip' => $request->ip()]
                );
            }
        }

        session()->forget('admin_id');
        
        return redirect()->route('admin.login')->with('success', 'You have been logged out successfully');
    }
}
