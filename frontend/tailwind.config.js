/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        'easycoach-primary': '#1e88e5',
        'easycoach-secondary': '#1565c0',
        'easycoach-accent': '#42a5f5',
      }
    },
  },
  plugins: [],
} 