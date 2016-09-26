const AssetsPlugin = require('assets-webpack-plugin');

module.exports = (config) => {
  config.plugins = [
    ...config.plugins,
    new AssetsPlugin({
      fullPath: false,
      filename: 'assets.json',
      prettyPrint: true
    })
  ];

  return config;
};
