import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class', // السطر ده هو اللي بيشغل الدارك مود بالزرار
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                xero: {
                    red: '#D32F2F',
                    dark: '#121212',
                    gray: '#1E1E1E',
                }
            },
            fontFamily: {
                sans: ['Cairo', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [forms],
};