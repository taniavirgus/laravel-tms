import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import flowbite from 'flowbite/plugin';
import colors from 'tailwindcss/colors';
import plugin from "tailwindcss/plugin"

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
  ],

  theme: {
    extend: {
      container: {
        center: true,
        padding: '2rem',
      },
      fontFamily: {
        sans: ['var(--font-sans)', ...defaultTheme.fontFamily.sans],
      },
      colors: {
        base: colors.zinc,
        primary: colors.blue
      }
    },
  },

  plugins: [
    forms,
    flowbite,
    plugin(({ addVariant }) => {
      addVariant("both", ["&:focus", "&:hover"])
    })
  ],
};
