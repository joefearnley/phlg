const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        colors: {
            blue: '#2d4053',
            transparent: 'transparent',
            current: 'currentColor',
            black: colors.black,
            red: colors.red,
            orange: colors.orange,
            amber: colors.amber,
            emerald: colors.emerald,
            cyan: colors.cyan,
            white: colors.white,
            indigo: colors.indigo,
            gray: colors.gray,
        },
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
