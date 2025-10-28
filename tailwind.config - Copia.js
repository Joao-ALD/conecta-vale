// tailwind.config.js

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
            // ADICIONE ESTE BLOCO DE CORES
            colors: {
                'vale-primary': '#007E7A', // Verde/Azulado Profundo
                'vale-secondary': '#00B0CA', // Azul Rio
                'vale-accent': '#ECB11F',  // Amarelo Ouro
            },
            // FIM DO BLOCO DE CORES
        },
    },

    plugins: [forms],
};