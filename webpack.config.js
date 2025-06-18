'use strict'

const { join } = require('path')
const CopyPlugin = require('copy-webpack-plugin')

const ROOT_PATH = __dirname

module.exports = {
    entry: join(ROOT_PATH, 'resources/assets/js/app.js'),
    output: {
        path: join(ROOT_PATH, 'public/assets/js'),
        filename: 'main.js',
        clean: true,
    },
    resolve: {
        alias: {
            '@': join(ROOT_PATH, 'resources/assets'),
        },
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
    plugins: [
        new CopyPlugin({
            patterns: [
                // ICONS
                {
                    from: join(ROOT_PATH, 'resources/assets/icons'),
                    to: join(ROOT_PATH, 'public/assets/icons')
                },
                // IMAGES
                {
                    from: join(ROOT_PATH, 'resources/assets/images'),
                    to: join(ROOT_PATH, 'public/assets/images')
                },
                // {
                //     from: join(ROOT_PATH, 'resources/assets/css'),
                //     to: join(ROOT_PATH, 'public/assets/css'),
                //     noErrorOnMissing: true,
                // },
            ],
        }),
    ],
}
