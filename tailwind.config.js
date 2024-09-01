/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Poppins", "Roboto", "sans-serif"],
            },
            colors: {
                danger: "#9E3F39",
                youngdanger: "#CB8E74",
                light: "#EFECE2",
                primary: "#003676",
                warning: "#E2BD5F",
            },
        },
    },
    plugins: [require("flowbite/plugin")],
};