const CleanPlugin = require('clean-webpack-plugin');
const paths = require('../paths');

const cleanDirs = [
  'js',
  'css'
];

const pluginConfig = {
  root: paths.assets,
  verbose: false,
  dry: false
};

module.exports = (config) => {
  config.plugins = [
    ...config.plugins,
    new CleanPlugin(cleanDirs, pluginConfig)
  ];

  return config;
};
