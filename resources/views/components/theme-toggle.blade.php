@props(['class' => ''])

<button type="button" onclick="toggleTheme()"
        {{ $attributes->merge(['class' => 'inline-flex items-center justify-center w-9 h-9 rounded-full text-stone-500 dark:text-stone-300 bg-clay-50/70 dark:bg-stone-800/70 hover:bg-clay-100 dark:hover:bg-stone-700 transition ease-in-out duration-150 ' . $class]) }}
        title="Ganti tema terang/gelap" aria-label="Ganti tema terang/gelap">
    <!-- Sun icon: shown in dark mode, click to switch to light -->
    <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <circle cx="12" cy="12" r="4"/>
        <path stroke-linecap="round" d="M12 2.5v2M12 19.5v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M2.5 12h2M19.5 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/>
    </svg>
    <!-- Moon icon: shown in light mode, click to switch to dark -->
    <svg class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z"/>
    </svg>
</button>
