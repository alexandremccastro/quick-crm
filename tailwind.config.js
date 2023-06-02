/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./resources/**/*.{vue,js,php}'],
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
