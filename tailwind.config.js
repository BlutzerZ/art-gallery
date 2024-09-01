/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                poppins: "Poppins",
                dancingScript: "'Dancing Script', cursive",
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
    plugins: [],
};

