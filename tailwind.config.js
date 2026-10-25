import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
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
                primary: {
                    50: '#fff1f5',
                    100: '#ffe4ed',
                    200: '#fecddc',
                    300: '#fda4be',
                    400: '#fb7199',
                    500: '#f43f75',
                    600: '#e11d5f',
                    700: '#be1250',
                    800: '#9f1245',
                    900: '#831843',
                },
                indigo: {
                    50: '#fff1f5',
                    100: '#ffe4ed',
                    200: '#fecddc',
                    300: '#fda4be',
                    400: '#fb7199',
                    500: '#f43f75',
                    600: '#e11d5f',
                    700: '#be1250',
                    800: '#9f1245',
                    900: '#831843',
                },
            },
        },
    },

    plugins: [forms],
};
