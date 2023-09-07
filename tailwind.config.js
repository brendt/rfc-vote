import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
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
        'bg-green-400',
        'bg-red-400',
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
            colors: {
                'agree': 'var(--color-agree)',
                'agree-light': 'var(--color-agree-light)',
                'agree-dark': 'var(--color-agree-dark)',
                'disagree': 'var(--color-disagree)',
                'disagree-light': 'var(--color-disagree-light)',
                'disagree-dark': 'var(--color-disagree-dark)',
                'main': 'var(--color-main)',
                'main-light': 'var(--color-main-light)',
                'main-dark': 'var(--color-main-dark)',
                'divider': 'var(--color-divider)',
                'info': 'var(--color-info)',

                // background
                'background': 'var(--color-background)',
                'admin-navbar-background': 'var(--color--admin-navbar-background)',
                'rfc-card': 'var(--color-rfc-card)',
                'argument-card': 'var(--color-argument-card)',
                'message-card': 'var(--color-message-card)',
                'code-background': 'var(--color-code-background)',

                // text color
                'font': 'var(--color-font)',
                'font-second': 'var(--color-font-second)',

                // vot-bar
                'vote-bar-background': 'var(--color-vote-bar-background)',

                // yes arrow
                'agree-arrow': 'var(--color-agree-arrow)',
                'agree-arrow-border': 'var(--color-agree-arrow-border)',
                'agree-arrow-hover': 'var(--color-agree-arrow-hover)',
                'agree-arrow-background': 'var(--color-agree-arrow-background)',

                // no arrow
                'disagree-arrow': 'var(--color-disagree-arrow)',
                'disagree-arrow-border': 'var(--color-disagree-arrow-border)',
                'disagree-arrow-hover': 'var(--color-disagree-arrow-hover)',
                'disagree-arrow-background': 'var(--color-disagree-arrow-background)',

                // form
                'form': 'var(--color-form)',
                'input': 'var(--color-input)',
            },
        },
    },

    plugins: [forms, typography],
};
