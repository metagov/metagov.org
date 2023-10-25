/** @type {import('tailwindcss').Config} */
module.exports = {
  theme: {
    extend: {
      colors: {
        brand: "#00CC99",
        primary: "#3464C3",
        secondary: "#008060",
        default: "#011B1A",
        bg: "#FEFFFE",
      },
      boxShadow: {
        window: "5px 5px 0px 0px rgba(0, 204, 153, 0.80);",
      },
    },
    container: {
      center: true,
      padding: "1rem",
    },
    fontSize: {
      xs: ["0.75rem", "12px"],
      tag: ["0.875rem", "14px"],
      small: ["1rem", "19.2px"],
      medium: ["1.25rem", "24px"],
      large: ["1.5rem", "28px"],
      xl: ["3rem", "48px"],
    },
    fontFamily: {
      sans: ["Inter"],
      serif: ["Times New Roman"],
      mono: ["input-mono-narrow"],
    },
  },
  plugins: [],
};