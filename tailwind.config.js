import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
import flowbite from 'flowbite/plugin';


/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                "primary": {
                    50: "#DBEFFA",
                    100: "#BBE2F6",
                    200: "#73C2ED",
                    300: "#2FA5E4",
                    400: "#177AB0",
                    500: "#0E4A6B",
                    600: "#0B3C56",
                    700: "#082C3F",
                    800: "#051C29",
                    900: "#031017",
                    950: "#010609"
                },
                "secondary": {
                    50: "#FDF3EC",
                    100: "#FBE4D5",
                    200: "#F8C9AA",
                    300: "#F4AF80",
                    400: "#F09456",
                    500: "#ED7B2E",
                    600: "#CF5D12",
                    700: "#9B460D",
                    800: "#672F09",
                    900: "#341704",
                    950: "#1C0D02"
                },
            },
            fontFamily: {
                'body': [
                    'Inter',
                    'ui-sans-serif',
                    'system-ui',
                    '-apple-system',
                    'system-ui',
                    'Segoe UI',
                    'Roboto',
                    'Helvetica Neue',
                    'Arial',
                    'Noto Sans',
                    'sans-serif',
                    'Apple Color Emoji',
                    'Segoe UI Emoji',
                    'Segoe UI Symbol',
                    'Noto Color Emoji'
                ],
                'sans': [
                    'Inter',
                    'ui-sans-serif',
                    'system-ui',
                    '-apple-system',
                    'system-ui',
                    'Segoe UI',
                    'Roboto',
                    'Helvetica Neue',
                    'Arial',
                    'Noto Sans',
                    'sans-serif',
                    'Apple Color Emoji',
                    'Segoe UI Emoji',
                    'Segoe UI Symbol',
                    'Noto Color Emoji'
                ]
            },
            transitionProperty: {
                'width': 'width'
            },
            screens: {
                'sm': '576px',
                // => @media (min-width: 576px) { ... }

                'md': '768px',
                // => @media (min-width: 768px) { ... }

                'lg': '1024px',
                // => @media (min-width: 1024px) { ... }

                'xl': '1280px',
                // => @media (min-width: 1280px) { ... }

                '2xl': '1536px',
                // => @media (min-width: 1536px) { ... }
            }
        },
    },

    plugins: [flowbite, forms, typography],
};
