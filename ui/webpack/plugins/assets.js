const AssetsPlugin = require('assets-webpack-plugin');

const pluginConfig = {
  fullPath: false,
  filename: 'assets.json',
  prettyPrint: true
};

module.exports = (config) => {
  config.plugins = [
    ...config.plugins,
    new AssetsPlugin(pluginConfig)
  ];

  return config;
};
