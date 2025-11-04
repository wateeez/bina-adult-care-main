<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserAdmin;

class AuthController extends Controller
{
    public function showLogin()
    {
        // dd('here');
        return view('admin.login');
    }
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            // Check if user exists first
            $user = User::where('email', $credentials['email'])->first();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            // Attempt authentication
            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials'
                ], 401);
            }

            // Get authenticated user
            $user = Auth::user();

            // Check if user is an admin
            $admin = UserAdmin::where('user_id', $user->id)->first();

            if (!$admin) {
                Auth::logout();
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Admin access required.'
                ], 403);
            }

            // Regenerate session for security
            session()->regenerate();
            
            return response()->json([
                'success' => true,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $admin->role
                ]
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Login error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during login'
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            // Revoke current token
            if ($request->user()) {
                $request->user()->currentAccessToken()->delete();
            }

            // Clear session
            Auth::guard('web')->logout();
            session()->invalidate();
            session()->regenerateToken();

            return response()->json([
                'success' => true,
                'message' => 'Successfully logged out'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error during logout',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}