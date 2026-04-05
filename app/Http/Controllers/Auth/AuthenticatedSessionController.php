<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Fetch the role of the authenticated user
        $role = $request->user()->role;

        // Route them to the correct dashboard based on their role
        return match ($role) {
            'admin' => redirect()->intended(route('admin.dashboard')),
            'doctor' => redirect()->intended(route('doctor.dashboard')),
            'pharmacist' => redirect()->intended(route('pharmacist.dashboard')),
            'patient' => redirect()->intended(route('patient.dashboard')),
            'secretary' => redirect()->intended(route('secretary.dashboard')),
            default => redirect()->route('home'),
        };
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
