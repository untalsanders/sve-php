"use strict";

const path = require("path");

module.exports = {
    mode: "development",
    entry: "./resources/assets/js/app.js",
    output: {
        path: path.resolve(__dirname, "public/assets/js"),
        filename: "bundle.js",
    },
    module: {
        rules: [
            {
                test: /\.css$/,
                use: ["style-loader", "css-loader"],
            },
        ],
    },
};
