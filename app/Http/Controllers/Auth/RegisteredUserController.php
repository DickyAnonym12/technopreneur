<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $imageName = null;

    if ($request->hasFile('foto_profile')) {
        $imageName = time() . '.' . $request->file('foto_profile')->extension();
        $request->file('foto_profile')->move(public_path('photo_profile'), $imageName);
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'role' => 'user',
        'password' => Hash::make($request->password),
        'foto_profile' => $imageName // langsung simpan di sini
    ]);

    event(new Registered($user));
    Auth::login($user);

    return redirect(route('home'));
}
}
