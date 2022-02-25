module.exports = {
  content: ["./resources/views/app.blade.php"],
  theme: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/typography'),
  ],
}

// Run with npx tailwindcss -i ./resources/src/app.css -o ./resources/assets/app.css [--watch] [--minify]
