import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                blue: {
                    200:"#67cfff",
                    400: '#0099D9',
                    600:"#4488d6",
                    800:"#4488d6"
                },
                primary:{
                    100:'#e6f4f1',
                    200:'#318f84',
                    300:'#394855',
                    400:'#EAEAEA',
                }
            },
            screens: {
                'xs': '425px'
            },
            animation: {
                typewriter: 'typewriter 2s steps(11) forwards',
                caret: 'typewriter 2s steps(11) forwards, blink 1s steps(11) infinite 2s',
            },
            keyframes: {
                typewriter: {
                    to: {
                        left: "100%"
                    }
                },
                blink: {
                    '0%': {
                        opacity: '0',
                    },
                    '0.1%': {
                        opacity: '1',
                    },
                    '50%': {
                        opacity: '1',
                    },
                    '50.1%': {
                        opacity: '0',
                    },
                    '100%': {
                        opacity: '0',
                    },
                },
            }
        },
    },
    plugins: [],
};
