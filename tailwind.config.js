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
                teal: {
                    850: '#115e59',
                },
            },
            boxShadow: {
                xs: '0 1px 2px 0 rgb(0 0 0 / 0.05)',
            },
            scale: {
                98: '0.98',
            },
        },
    },

    plugins: [forms],
};
