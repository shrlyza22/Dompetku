<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-stone-900 border-clay-200 dark:border-stone-700 text-clay-500 shadow-sm focus:ring-clay-500 dark:focus:ring-clay-600 dark:focus:ring-offset-stone-900" name="remember">
                <span class="ms-2 text-sm text-stone-600 dark:text-stone-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-stone-600 dark:text-stone-400 hover:text-clay-600 dark:hover:text-clay-300 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-clay-500 dark:focus:ring-offset-stone-900" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
        <div class="mt-6 text-center">
    <a href="{{ route('google.redirect') }}"
       class="flex w-full items-center justify-center gap-2 rounded-full border border-clay-200 bg-white px-4 py-2 text-sm font-semibold text-stone-700 shadow-sm hover:bg-clay-50 dark:border-stone-600 dark:bg-stone-800 dark:text-stone-200 dark:hover:bg-stone-700">
        Masuk dengan Google
    </a>
</div>
    </form>
</x-guest-layout>
