import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import flowbite from 'flowbite/plugin';
import colors from 'tailwindcss/colors';
import plugin from "tailwindcss/plugin"

/** @type {import('tailwindcss').Config} */
export default {
  darkMode: null,
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
  ],
  safelist: [
    {
      pattern: /(bg|border|text)-(base|red|green|yellow|amber|indigo|emerald|blue)-(500)/,
    },
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
      },
      spacing: {
        'icon': '46px',
      },
      aspectRatio: {
        'banner': '3/1',
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
