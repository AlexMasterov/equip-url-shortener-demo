const ExtractTextPlugin = require('extract-text-webpack-plugin');
const paths = require('../paths');

let styleLoader = {
  loader: 'style-loader'
};

let cssLoader = {
  loader: 'css-loader',
  query: {
    modules: true,
    importLoaders: true,
    localIdentName: '[hash:base64:5]'
  }
};

let postcssLoader = {
  loader: 'postcss-loader',
  query: {
    parser: 'sugarss'
  }
};

let extractTextLoader = ExtractTextPlugin.extract({
  fallbackLoader: 'style-loader',
  loader: [
    cssLoader,
    postcssLoader
  ]
});

let sssLoader = {
  loader: extractTextLoader,
  test: /\.sss$/,
  include: paths.source
};

module.exports = (config) => {
  config.resolve.extensions = [
    ...config.resolve.extensions,
    '.sss'
  ];

  config.plugins = [
    ...config.plugins,
    new ExtractTextPlugin({
      allChunks: true,
      filename: `assets/css/styles-[contenthash:8].css`
    })
  ];

  config.module.rules = [
    ...config.module.rules,
    sssLoader
  ];

  return config;
};
