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
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
                serif: ['"Playfair Display"', ...defaultTheme.fontFamily.serif],
                script: ['"Alex Brush"', 'cursive'],
            },
            colors: {
                blush: {
                    50: '#fdf6f3',
                    100: '#faeae3',
                    200: '#f5d6c9',
                    300: '#edb8a3',
                    400: '#e2937a',
                    500: '#d4715a',
                    600: '#c15a45',
                    700: '#a14837',
                    800: '#833c30',
                    900: '#6c342b',
                },
                rose: {
                    50: '#fdf3f5',
                    100: '#fbe7ea',
                    200: '#f6cdd6',
                    300: '#eea3b3',
                    400: '#e2748d',
                    500: '#d14f6d',
                    600: '#b8395a',
                    700: '#992d49',
                    800: '#7f2840',
                    900: '#6c253a',
                },
                cream: {
                    50: '#fffdfb',
                    100: '#fdf8f2',
                    200: '#f9efe2',
                },
            },
            boxShadow: {
                soft: '0 10px 40px -12px rgba(177, 92, 100, 0.25)',
            },
        },
    },

    plugins: [forms],
};
