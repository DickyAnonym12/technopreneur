<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;
use Laravel\Socialite\Facades\Socialite;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard2');
        }
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        // Ambil user yang sedang login
        $user = Auth::user();

        // Cek role dan arahkan sesuai dengan role
        if ($user->role == 'admin') {
            return redirect()->route('dashboard2');
        } elseif ($user->role == 'user') {
            return redirect()->route('home');
        }

        // Default redirect jika role tidak sesuai
        return redirect()->route('home');
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

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {
        // Mendapatkan informasi pengguna dari Google
        $googleUser = Socialite::driver('google')->stateless()->user();
        $email_user = $googleUser->getEmail();

        // Mencari pengguna berdasarkan email
        $user = User::where('email', $email_user)->first();

        if ($user) {
            // Login pengguna jika ditemukan
            Auth::login($user);
            return redirect()->route('dashboard2')->with('success', true);
        } else {
            // Jika pengguna tidak terdaftar, redirect ke login dengan pesan error
            return redirect()->route('login')->with('error', 'Akun tidak terdaftar');
        }
    }
}
