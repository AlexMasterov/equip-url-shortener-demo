const CleanPlugin = require('clean-webpack-plugin');
const paths = require('../paths');

module.exports = (config) => {
  config.plugins = [
    ...config.plugins,
    new CleanPlugin(['js', 'css'], {
      root: paths.assets,
      verbose: false
    })
  ];

  return config;
};
