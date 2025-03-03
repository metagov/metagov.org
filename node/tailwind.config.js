/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        brand: "#00CC99",
        primary: "#3464C3",
        secondary: "#008060",
        "secondary-dark": "#46D3CA",
        default: "#011B1A",
        bg: "#FEFFFE",
      },
      boxShadow: {
        window: "5px 5px 0px 0px rgba(0, 204, 153, 0.2)",
        windowhover: "8px 8px 8px 0px rgba(0, 204, 153, 0.2)",
      },
      opacity: {
        15: "0.15",
      },
    },
    container: {
      center: true,
      padding: "1rem",
    },
    fontSize: {
      xxs: ["0.825rem", "0.8rem"],
      tag: ["0.875rem", "1rem"],
      xs: ["0.9rem", "1rem"],
      small: ["1rem", "1.4rem"],
      medium: ["1.2rem", "1.8rem"],
      large: ["1.6rem", "2rem"],
      xl: ["2rem", "2.5rem"],
      xxl: ["2.5rem", "2.8rem"],
    },
    fontFamily: {
      sans: ["Inter"],
      serif: ["EB Garamond", "Times", "Times New Roman"],
      mono: ["input-mono-narrow"],
    }
  },
  plugins: [],
};
