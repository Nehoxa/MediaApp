const defaultTheme = require("tailwindcss/defaultTheme");

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            width: {
                129: "33rem",
                130: "35rem",
            },
            height: {
                115: "25rem",
                150: "45rem",
            },
            screens: {
                "3xl": "1800px",
            },
            boxShadow: {
                "hover": "0 35px 60px -15px rgba(0, 0, 0, 0.2)",
            },
        },
    },

    plugins: [require("@tailwindcss/forms")],
};
