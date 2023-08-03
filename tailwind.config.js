import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    safelist: [
        'bg-red-100',
        'bg-green-100',
        'hover:bg-red-400',
        'hover:bg-green-400',
        'active:bg-red-400',
        'active:bg-green-400',
        'border-red-200',
        'border-green-200',
        'border-red-400',
        'border-green-400',
        'text-green-800',
        'text-red-800',
        'flex-row',
        'flex-row-reverse',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms, typography],
};
