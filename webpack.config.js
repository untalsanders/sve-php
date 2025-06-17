'use strict'

const { resolve } = require('path')

module.exports = {
    entry: './resources/assets/js/app.js',
    output: {
        path: resolve(__dirname, 'public/assets/js'),
        filename: 'bundle.js',
        clean: true,
    },
    resolve: {
        alias: {
            '@': resolve(__dirname, './resources/assets/'),
        }
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /(node_modules|bower_components)/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env'],
                    },
                },
            },
            {
                test: /\.css$/,
                use: ['style-loader', 'css-loader'],
            },
        ],
    },
}
