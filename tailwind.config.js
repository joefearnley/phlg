const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

module.exports = {
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
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
            indigo:  colors.indigo
        },
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
