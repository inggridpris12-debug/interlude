<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
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
        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        \Log::info('Login attempt', ['email' => $credentials['email']]);

        // Try admin guard first
        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            \Log::info('Admin authenticated', ['email' => $credentials['email']]);

            return redirect()->route('admin.dashboard_admin');
        }

        // Try user guard
        if (Auth::guard('web')->attempt($credentials, $remember)) {
            \Log::info('User authenticated', ['email' => $credentials['email']]);

            return redirect()->route('dashboard');
        }

        \Log::info('Login failed', ['email' => $credentials['email']]);
        throw ValidationException::withMessages([
            'email' => 'Kredensial tidak valid.',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
