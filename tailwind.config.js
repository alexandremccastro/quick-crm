/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./resources/**/*.{vue,js}'],
  plugins: [require('daisyui')],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [require('daisyui')],
}
