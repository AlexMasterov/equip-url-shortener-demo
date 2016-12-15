const paths = require('../paths');

module.exports = (config) => {
  config.resolve.extensions = [
    ...config.resolve.extensions,
    '.js'
  ];

  config.module.rules = [
    ...config.module.rules,
    {
      test: /\.js$/,
      include: paths.source,
      use: [{
        loader: 'babel-loader',
        query: require('./babel-preset.js')
      }]
    }
  ];

  return config;
};
