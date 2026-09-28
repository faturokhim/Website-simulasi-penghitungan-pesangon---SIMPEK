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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },

            colors: {
                /* Primary palette - government / corporate teal */
                primary: {
                    DEFAULT: '#0F766E',
                    50: '#F0FDFA',
                    100: '#CCFBF1',
                    200: '#99F6E4',
                    300: '#5EEAD4',
                    400: '#2DD4BF',
                    500: '#14B8A6',
                    600: '#0D9488',
                    700: '#0F766E',
                    800: '#115E59',
                    900: '#134E4A',
                    950: '#042F2E',
                },
                /* Surface tokens */
                canvas: '#F8FAFC',
                surface: '#FFFFFF',
            },

            borderRadius: {
                /* Spec: input/button 8px, card/modal 12px, badge 6px.
                   The numeric scale is capped at 12px so legacy rounded-2xl/3xl
                   classes also land on the design-system radius. */
                sm: '4px',
                DEFAULT: '4px',
                md: '6px',
                lg: '8px',
                xl: '8px',
                '2xl': '12px',
                '3xl': '12px',
                input: '8px',
                button: '8px',
                card: '12px',
                modal: '12px',
                badge: '6px',
            },

            boxShadow: {
                card: '0 1px 2px 0 rgb(15 23 42 / 0.05), 0 1px 3px 0 rgb(15 23 42 / 0.10)',
                'card-hover': '0 4px 10px -2px rgb(15 23 42 / 0.10), 0 2px 6px -2px rgb(15 23 42 / 0.08)',
                xs: '0 1px 2px 0 rgb(15 23 42 / 0.05)',
            },

            scale: {
                98: '0.98',
            },
        },
    },

    plugins: [forms],
};
