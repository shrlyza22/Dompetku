import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Warm terracotta — primary brand accent
                clay: {
                    50: '#FDF4F1',
                    100: '#FBE7DF',
                    200: '#F5CDBC',
                    300: '#EDAD8F',
                    400: '#E08863',
                    500: '#CC6B45',
                    600: '#AD5636',
                    700: '#8B452C',
                    800: '#6E3722',
                    900: '#582C1C',
                },
                // Soft dusty pink — used for expenses / secondary highlights
                blush: {
                    50: '#FDF3F4',
                    100: '#FAE4E7',
                    200: '#F3C7CE',
                    300: '#E9A3AE',
                    400: '#DC7A8A',
                    500: '#C85B6D',
                    600: '#A84457',
                    700: '#863548',
                    800: '#6B2B3A',
                    900: '#54242F',
                },
                // Muted sage green — used for income / positive states
                sage: {
                    50: '#F5F6F0',
                    100: '#E8EBDC',
                    200: '#D2D9BA',
                    300: '#B7C393',
                    400: '#9AAC70',
                    500: '#7F9457',
                    600: '#647645',
                    700: '#4F5D38',
                    800: '#3F4A2E',
                    900: '#333C26',
                },
                // Warm cream/sand — page backgrounds
                sand: {
                    50: '#FEFBF6',
                    100: '#FBF4EA',
                    200: '#F5E7D3',
                    300: '#ECD6B4',
                    400: '#DEBD8B',
                    500: '#CBA066',
                },
            },
        },
    },

    plugins: [forms],
};
