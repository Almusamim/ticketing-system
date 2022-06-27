/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./resources/js/**/*.{vue,js}"],
  theme: {
    extend: {
      colors: {
        brand: {
          50: '#fff4ff',
          100: '#fee7ff',
          200: '#fdceff',
          300: '#ffa8ff',
          400: '#fe74fd',
          500: '#f540f1',
          600: '#d920d2',
          700: '#b417ab',
          800: '#931589',
          900: '#78176f',
        },
      },
      keyframes: {
        'fade-in-down': {
          "from": {
            transform: "translateY(-0.75rem)",
            opacity: '0'
          },
          "to": {
            transform: "translateY(0rem)",
            opacity: '1'
          },
        },
      },
      animation: {
        'fade-in-down': "fade-in-down 0.2s ease-in-out both",
      },
    }
  },
  extend: {
  },
  plugins: [],
}