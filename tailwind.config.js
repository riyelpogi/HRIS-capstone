import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

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
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },

            colors: {
                'dim-grey' : '#6E6E6E',
                'yellow-green' : '#BAFF39',
                'light-blue' : '#E9F1FA',
                'bright-blue' : '#00ABE4',
                'whitey' : '#FBF9F1'
            },
            screens: {
                'xsmr': {'min': '', 'max': '640px'},

                'smr': {'min': '640px', 'max': '767px'},
                // => @media (min-width: 640px and max-width: 767px) { ... }
          
                'mdr': {'min': '768px', 'max': '1023px'},
                // => @media (min-width: 768px and max-width: 1023px) { ... }
          
                'lgr': {'min': '1024px', 'max': '1279px'},
                // => @media (min-width: 1024px and max-width: 1279px) { ... }
          
                'xlr': {'min': '1280px', 'max': '1535px'},
                // => @media (min-width: 1280px and max-width: 1535px) { ... }
          
                '2xlr': {'min': '1536px'},
                // => @media (min-width: 1536px) { ... }
                '3xlr': {'min': '1537px', 'max' : ''},
              },
        },
    },

    plugins: [forms, typography],
};
