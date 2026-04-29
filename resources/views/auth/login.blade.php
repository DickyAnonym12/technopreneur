<x-guest-layout>
    <!-- Session Status -->

    <head>
        <link rel="stylesheet" href="{{ asset('assets/images/konya.jpg') }}">
    </head>

    <!-- Logo Image -->
    <div class="flex justify-center mt-6">
        <img src="{{ asset('assets/images/LOGOKONYA.png') }}" alt="Logo" class="w-20 h-20 shadow-lg">
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password"
                class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-500"
                type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Login Button -->
        <div class="flex justify-center mt-6">
            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 transition duration-200 px-6 py-2">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <!-- Login with Google Button -->
        <div class="flex justify-center mt-4">
            <a href="{{ route('redirect.google') }}"
                class="flex items-center justify-center w-full bg-gray-200 hover:bg-gray-300 transition duration-200 py-2 rounded-md text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-google" viewBox="0 0 16 16">
                    <path
                        d="M15.545 6.558a9.4 9.4 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.7 7.7 0 0 1 5.352 2.082l-2.284 2.284A4.35 4.35 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.8 4.8 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.7 3.7 0 0 0 1.599-2.431H8v-3.08z" />
                </svg>
                {{ __('Login with Google') }}
            </a>
        </div>
    </form>
</x-guest-layout>
