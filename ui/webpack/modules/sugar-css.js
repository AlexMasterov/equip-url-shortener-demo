const ExtractTextPlugin = require('extract-text-webpack-plugin');
const paths = require('../paths');

let cssLoader = {
  loader: 'css',
  query: {
    modules: true,
    importLoaders: 1,
    localIdentName: '[hash:base64:5]'
  }
};

let postcssLoader = {
  loader: 'postcss',
  query: {
    parser: 'sugarss'
  }
};

let extractTextLoader = ExtractTextPlugin.extract({
  fallbackLoader: 'style',
  loader: [
    cssLoader,
    postcssLoader
  ]
});

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
    {
      test: /\.sss$/,
      include: paths.source,
      loader: extractTextLoader
    }
  ];

  return config;
};
