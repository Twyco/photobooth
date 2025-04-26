import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './node_modules/@twyco/vue-image-system/**/*.{js,ts,vue}',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', 'sans-serif'],
            },
            colors: {
                primary: "#e5e7eb",
                secondary: "#2563eb",
                'dark-background': "#131314",
                'footer': "#262626",
                'highlight': "#9ca3af"
            },
            keyframes: {
                shake: {
                    '0%, 100%': { transform: 'translateX(0)' },
                    '25%': { transform: 'translateX(-5px)' },
                    '75%': { transform: 'translateX(5px)' },
                },
            },
            animation: {
                shake: 'shake 0.2s ease-in-out',
            },
            borderWidth: {
                '1': '1px',
            }
        },
    },

    plugins: [forms],
};
