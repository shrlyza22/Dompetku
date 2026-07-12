<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-blush-500 border border-transparent rounded-full font-bold text-xs text-white uppercase tracking-widest hover:bg-blush-600 active:bg-blush-700 focus:outline-none focus:ring-2 focus:ring-blush-400 focus:ring-offset-2 dark:focus:ring-offset-stone-900 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
