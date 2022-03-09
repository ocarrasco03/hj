const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require("tailwindcss/colors");

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
                body: ["Nunito Sans", ...defaultTheme.fontFamily.sans],
            },
        },
        colors: {
            transparent: "transparent",
            black: colors.black,
            white: colors.white,
            primary: {
                DEFAULT: "#fbc60a",
                50: "#fff8e2",
                100: "#feeeb6",
                200: "#fde385",
                300: "#fcd754",
                400: "#fccf2f",
                500: "#fbc60a",
                600: "#fac009",
                700: "#fab907",
                800: "#f9b105",
                900: "#f8a403",
            },
            secondary: {
                DEFAULT: "#252222",
                50: "#e5e4e4",
                100: "#bebdbd",
                200: "#929191",
                300: "#666464",
                400: "#464343",
                500: "#252222",
                600: "#211e1e",
                700: "#1b1919",
                800: "#161414",
                900: "#0d0c0c",
            },
            gray: {
                50: "#f3f3f3",
                100: "#e0e0e0",
                200: "#cbcbcb",
                300: "#b6b6b6",
                400: "#a7a7a7",
                500: "#979797",
                600: "#8f8f8f",
                700: "#848484",
                800: "#7a7a7a",
                900: "#696969",
            },
            blue: {
                50: "#e7eeff",
                100: "#c4d4fe",
                200: "#9db8fe",
                300: "#769cfd",
                400: "#5886fc",
                500: "#3b71fc",
                600: "#3569fc",
                700: "#2d5efb",
                800: "#2654fb",
                900: "#1942fa",
            },
            green: {
                50: "#f9fef2",
                100: "#f0fede",
                200: "#e6fdc8",
                300: "#dcfcb2",
                400: "#d5fba2",
                500: "#cdfa91",
                600: "#c8f989",
                700: "#c1f97e",
                800: "#baf874",
                900: "#aef662",
            },
            red: {
                50: "#ffe0e0",
                100: "#ffb3b3",
                200: "#ff8080",
                300: "#ff4d4d",
                400: "#ff2626",
                500: "#ff0000",
                600: "#ff0000",
                700: "#ff0000",
                800: "#ff0000",
                900: "#ff0000",
            },
            yellow: {
                50: "#fff8e2",
                100: "#feeeb6",
                200: "#fde385",
                300: "#fcd754",
                400: "#fccf2f",
                500: "#fbc60a",
                600: "#fac009",
                700: "#fab907",
                800: "#f9b105",
                900: "#f8a403",
            }
        },
    },

    plugins: [require('@tailwindcss/forms'), require("@tailwindcss/typography"),],
};
