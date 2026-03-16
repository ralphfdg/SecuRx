<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Kick them to login if they aren't authenticated at all
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Check if their database role matches the route's required role
        if (Auth::user()->role !== $role) {
            // Kick them back to their own specific dashboard
            return redirect('/' . Auth::user()->role . '/dashboard')->with('error', 'Unauthorized access.');
        }

        // 3. If the roles match perfectly, let them through!
        return $next($request);
    }
}
