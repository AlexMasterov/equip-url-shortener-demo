const AssetsPlugin = require('assets-webpack-plugin');

module.exports = (config) => {
  config.plugins = [
    ...config.plugins,
    new AssetsPlugin({
      filename: 'assets.json',
      fullPath: true,
      prettyPrint: true
    })
  ];

  return config;
};
