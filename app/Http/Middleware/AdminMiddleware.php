<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // For local development, log authentication attempts
        if (app()->environment('local')) {
            Log::info('Admin authentication attempt', [
                'user' => Auth::user(),
                'path' => $request->path(),
                'ip' => $request->ip()
            ]);
        }

        if (Auth::check() && Auth::user()->admin()->exists()) {
            return $next($request);
        }

        if (app()->environment('local') && config('app.debug')) {
            // In local development, log the authentication failure
            Log::warning('Admin authentication failed', [
                'user' => Auth::user(),
                'path' => $request->path(),
                'ip' => $request->ip(),
                'has_admin' => Auth::check() ? Auth::user()->admin()->exists() : false
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Admin access required.',
                'debug' => app()->environment('local') ? [
                    'user' => Auth::user(),
                    'isAuth' => Auth::check(),
                    'isAdmin' => Auth::check() ? Auth::user()->admin : false
                ] : null
            ], 403);
        }

        return redirect()->route('login')->with('error', 'Admin access required');
    }
}