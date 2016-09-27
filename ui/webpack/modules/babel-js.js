const paths = require('../paths');

module.exports = (config) => {
  config.resolve.extensions = [
    ...config.resolve.extensions,
    '.js'
  ];

  config.module.loaders = [
    ...config.module.loaders,
    {
      test: /\.js$/,
      include: paths.source,
      loaders: 'babel',
      query: require('./babel-preset.js')
    }
  ];

  return config;
};
