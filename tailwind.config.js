const defaultTheme = require('tailwindcss/defaultTheme');
const tailwindColors = require('tailwindcss/colors');

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
        'border-red-400',
        'border-emerald-500',
        'border-emerald-400',
        'border-amber-500',
        'border-amber-400',
        'text-red-500',
        'text-red-400',
        'text-emerald-500',
        'text-emerald-400',
        'text-amber-500',
        'text-amber-400',
        'bg-slate-400',
        'bg-slate-500',
        'bg-slate-600',
        'bg-slate-700',
        'bg-slate-800',
        'ring-slate-300',
        'ring-slate-800',
    ],
    theme: {
        colors: {
            blue: '#2d4053',
            transparent: 'transparent',
            current: 'currentColor',
            black: tailwindColors.black,
            red: tailwindColors.red,
            orange: tailwindColors.orange,
            amber: tailwindColors.amber,
            emerald: tailwindColors.emerald,
            cyan: tailwindColors.cyan,
            white: tailwindColors.white,
            indigo: tailwindColors.indigo,
            gray: tailwindColors.gray,
            slate: tailwindColors.slate,
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
