const paths = require('./webpack/paths');

let config = {
  devtool: false,
  performance: {
    hints: false
  },

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

  module: {
    rules: []
  },

  plugins: []
};

// Modules
config = require('./webpack/modules/babel-js')(config);
config = require('./webpack/modules/sugar-css')(config);

// Plugins
config = require('./webpack/plugins/define')(config);
config = require('./webpack/plugins/md5-hash')(config);
config = require('./webpack/plugins/clean')(config);
config = require('./webpack/plugins/assets')(config);
config = require('./webpack/plugins/uglify')(config);
config = require('./webpack/plugins/postcss')(config);

module.exports = config;
