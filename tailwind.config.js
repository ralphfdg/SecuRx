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
            colors: {
                // Official SecuRx Brand Colors
                securx: {
                    cyan: '#1CB5D1', // The vibrant primary logo color
                    navy: '#2C348A', // The deep accent logo color
                    gold: '#D6A850', // The accent from your previous palette
                    dark: '#0B1120', // The deep void background for dark mode
                }
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [forms],
};