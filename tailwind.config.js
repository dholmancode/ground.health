/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './wp-content/themes/ground.health-theme/**/*.php',
    './wp-content/themes/ground.health-theme/**/*.js',
  ],
  theme: {
    extend: {
      fontFamily: {
        heading: ['Poppins', 'sans-serif'],
        body: ['Inter', 'sans-serif'],
      },
      colors: {
        brand: {
          primary: '#E07A5F',      // Terracotta
          secondary: '#3D5A5B',    // Muted Teal
          light: '#F4E1D2',        // Soft Peach
          dark: '#2E2E2E',         // Charcoal
          neutral: '#EAE3D2',      // Warm Beige
          accent: '#FFCC70',       // Sun Gold
        },
      },
    },
  },
  plugins: [],
}
