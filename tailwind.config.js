/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
    "./node_modules/tw-elements/dist/js/**/*.js",
  ],
  theme: {
    extend: {
      fontFamily: {
        lato: ["Lato", "sans-serif"],
        limelight: ["Limelight", "sans-serif"],
      },
      screens: {
        lg: "1024px",
      },
    },
  },
  plugins: [require("@tailwindcss/forms")],
};
