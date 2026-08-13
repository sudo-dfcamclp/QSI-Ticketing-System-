/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./**/*.{php,html,js}",
  ],
  theme: {
    extend: {
      colors: {
        canvas:    '#F4F6F3',
        surface:   '#FFFFFF',
        ink:       '#14211A',
        inkmuted:  '#63735F',
        pine:      '#0E5B45',
        pinedark:  '#0A4634',
        pinetint:  '#E7F0EB',
        amber:     '#C2660B',
        hairline:  '#DEE5DF',
      },
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
        mono: ['"IBM Plex Mono"', 'monospace'],
      },
    },
  },
  plugins: [],
}