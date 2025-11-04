<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\UserAdmin;

class WebAuthController extends Controller
{
    public function showLogin()
    {
        // If already logged in, redirect to dashboard
        if (Auth::check() && Auth::user()->admin) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                
                // Check if user is an admin using the relationship
                if (!$user->admin()->exists()) {
                    Auth::logout();
                    return back()
                        ->withInput($request->only('email'))
                        ->withErrors(['email' => 'Unauthorized. Admin access required.']);
                }

                $request->session()->regenerate();
                return redirect()->intended('admin/dashboard');
            }

            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Invalid credentials']);

        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'An error occurred during login']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}