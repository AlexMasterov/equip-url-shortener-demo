const path = require('path');
const webpack = require('webpack');
const paths = require('./webpack/paths');

let config = {
  devtool: false,

  entry: {
    bundle: `${paths.source}/index.js`
  },

  output: {
    path: paths.dist,
    filename: 'assets/js/[name]-[chunkhash:8].js',
    publicPath: '/'
  },

  resolve: {
    extensions: [],
    modules: [
      paths.source,
      'node_modules'
    ]
  },

  plugins: [
    new webpack.DefinePlugin({
      'process.env.NODE_ENV': JSON.stringify(process.env.NODE_ENV),
      __DEV__: false
    })
  ],

  module: {
    loaders: []
  }
};

// Plugins
config = require('./webpack/plugins/md5-hash')(config);
config = require('./webpack/plugins/clean')(config);
config = require('./webpack/plugins/assets')(config);
config = require('./webpack/plugins/uglify')(config);
config = require('./webpack/plugins/postcss')(config);

// Modules
config = require('./webpack/modules/babel-js')(config);
config = require('./webpack/modules/sugar-css')(config);

module.exports = config;
