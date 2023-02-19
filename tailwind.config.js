const defaultTheme = require('tailwindcss/defaultTheme');
const tailwindColors = require('tailwindcss/colors');

// console.log(tailwindColors);

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    safelist: [
        'border-red-500',
        'border-emerald-500',
        'border-amber-500',
        'text-red-500',
        'text-emerald-500',
        'text-amber-500',
    ],
    theme: {
        colors: {
            blue: '#2d4053',
            transparent: 'transparent',
            current: 'currentColor',
            black: tailwindColors.black,
            red: tailwindColors.red,
            // red: '#ef4444',
            orange: tailwindColors.orange,
            amber: tailwindColors.amber,
            emerald: tailwindColors.emerald,
            cyan: tailwindColors.cyan,
            white: tailwindColors.white,
            indigo: tailwindColors.indigo,
            gray: tailwindColors.gray,
        },
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography')
    ],
};
