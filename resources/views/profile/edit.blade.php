<x-app-layout>
    <x-slot name="title">{{ __('Profil') }}</x-slot>
    <x-slot name="header">
        <h2 class="font-extrabold text-xl text-stone-800 dark:text-stone-200 leading-tight">
            {{ __('Profil Kamu') }} 👤
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-10 space-y-6">
            <div class="p-4 sm:p-8 glass-card shadow-sm rounded-3xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 glass-card shadow-sm rounded-3xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 glass-card shadow-sm rounded-3xl border-blush-500/20">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
