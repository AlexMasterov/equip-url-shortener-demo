const DefinePlugin = require('webpack').DefinePlugin;

module.exports = (config) => {
  config.plugins = [
    ...config.plugins,
    new DefinePlugin({
      'process.env.NODE_ENV': JSON.stringify(process.env.NODE_ENV),
      __DEV__: false
    })
  ];

  return config;
};
