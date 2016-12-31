const { resolve } = require('path');

let config = {
  devtool: false,
  cache: true,

  stats: {},
  performance: {
    hints: false
  },

  context: resolve(__dirname, 'src'),

  entry: {
    bundle: [
      './index.js'
    ]
  },

  output: {
    publicPath: '/assets/',
    path: resolve(__dirname, '..', 'public', 'assets'),
    filename: 'js/[name]-[chunkhash:8].js',
    chunkFilename: '[name]-[chunkhash:8].js'
  },

  resolve: {
    alias: {},
    extensions: [],
    modules: [
      resolve(__dirname, 'src'),
      'node_modules'
    ]
  },

  module: {
    rules: [],
    noParse: []
  },

  plugins: []
};

// Modules
config = require('./webpack/modules/babel')(config);
config = require('./webpack/modules/sugar')(config);
config = require('./webpack/modules/noParse')(config);

// Plugins
config = require('./webpack/plugins/define')(config);
config = require('./webpack/plugins/md5Hash')(config);
config = require('./webpack/plugins/uglify')(config);
config = require('./webpack/plugins/assets')(config);
config = require('./webpack/plugins/clean')(config);

module.exports = config;
