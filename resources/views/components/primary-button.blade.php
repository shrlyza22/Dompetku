<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-clay-500 dark:bg-clay-500 border border-transparent rounded-full font-bold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-clay-600 dark:hover:bg-clay-600 focus:bg-clay-600 active:bg-clay-700 focus:outline-none focus:ring-2 focus:ring-clay-400 focus:ring-offset-2 dark:focus:ring-offset-stone-900 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
