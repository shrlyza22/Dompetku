<nav x-data="{ open: false }" class="sticky top-0 z-40 bg-white/60 dark:bg-stone-900/60 backdrop-blur-xl border-b border-clay-100/80 dark:border-stone-800/60 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- LEFT: Logo + Nav Links -->
            <div class="flex items-center">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 shrink-0">
                    <span class="flex items-center justify-center w-9 h-9 rounded-2xl bg-gradient-to-br from-clay-400 to-blush-400 text-white shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5A2.5 2.5 0 015.5 5h11A2.5 2.5 0 0119 7.5v9a2.5 2.5 0 01-2.5 2.5h-11A2.5 2.5 0 013 16.5v-9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a1.25 1.25 0 100-2.5 1.25 1.25 0 000 2.5z"/>
                        </svg>
                    </span>
                    <span class="font-extrabold text-base text-stone-800 dark:text-stone-100 tracking-tight hidden sm:block">Dompetku</span>
                </a>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:items-center sm:ms-8 space-x-1">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.*')">
                        {{ __('Transaksi') }}
                    </x-nav-link>
                    <x-nav-link :href="route('wallets.index')" :active="request()->routeIs('wallets.*')">
                        {{ __('Dompet') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- RIGHT: Language + Theme + Profile -->
            <div class="hidden sm:flex sm:items-center gap-2">

                <!-- Language Selector -->
                <x-dropdown align="right" width="36">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-extrabold text-stone-600 dark:text-stone-300 bg-clay-50/70 dark:bg-stone-800/70 hover:bg-clay-100 dark:hover:bg-stone-700 focus:outline-none transition duration-150 active:scale-95">
                            <span>🌐 {{ strtoupper(session('locale', config('app.locale'))) }}</span>
                            <svg class="w-3 h-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link href="{{ route('set-locale', 'id') }}" class="flex items-center gap-2">
                            🇮🇩 Bahasa (ID)
                        </x-dropdown-link>
                        <x-dropdown-link href="{{ route('set-locale', 'en') }}" class="flex items-center gap-2">
                            🇬🇧 English (EN)
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>

                <!-- Theme Toggle -->
                <x-theme-toggle />

                <!-- Profile Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 pl-1 pr-3 py-1 rounded-full text-sm font-semibold text-stone-700 dark:text-stone-200 bg-clay-50/70 dark:bg-stone-800/70 hover:bg-clay-100 dark:hover:bg-stone-700 focus:outline-none transition duration-150">
                            @if(Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}"
                                     class="w-7 h-7 rounded-full object-cover shrink-0 aspect-square ring-2 ring-clay-200 dark:ring-stone-700">
                            @else
                                <span class="flex items-center justify-center w-7 h-7 aspect-square rounded-full bg-gradient-to-br from-clay-300 to-blush-300 text-white text-xs font-extrabold shrink-0">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                            @endif
                            <span class="text-sm font-semibold">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 fill-current text-stone-400 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profil') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center gap-2 sm:hidden">
                <!-- Mobile Language Selector -->
                <x-dropdown align="right" width="36">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center justify-center p-2 rounded-xl text-stone-500 dark:text-stone-400 hover:text-clay-600 dark:hover:text-clay-300 hover:bg-clay-50 dark:hover:bg-stone-800 transition active:scale-95 text-xs font-bold gap-1">
                            <span>🌐 {{ strtoupper(session('locale', config('app.locale'))) }}</span>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link href="{{ route('set-locale', 'id') }}">
                            🇮🇩 ID
                        </x-dropdown-link>
                        <x-dropdown-link href="{{ route('set-locale', 'en') }}">
                            🇬🇧 EN
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>

                <x-theme-toggle />

                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-stone-400 dark:text-stone-500 hover:text-clay-600 dark:hover:text-clay-300 hover:bg-clay-50 dark:hover:bg-stone-800 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white/80 dark:bg-stone-900/80 backdrop-blur-xl border-t border-clay-100/80 dark:border-stone-800/60">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.*')">
                {{ __('Transaksi') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('wallets.index')" :active="request()->routeIs('wallets.*')">
                {{ __('Dompet') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-clay-100 dark:border-stone-800">
            <div class="px-4">
                <div class="font-bold text-base text-stone-800 dark:text-stone-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-stone-500 dark:text-stone-400">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profil') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
