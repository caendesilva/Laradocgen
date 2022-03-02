module.exports = {
  content: ["./resources/views/*.blade.php"],
  darkMode: 'class',
  theme: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/typography'),
  ],
}

// Run with npx tailwindcss -i ./resources/assets/app.css -o ./resources/docs/media/app.css [--watch] [--minify]
