const paths = require('./paths');

module.exports = {
  babelrc: false,
  compact: true,
  cacheDirectory: paths.cache,
  presets: [
    [require.resolve('babel-preset-latest'), { modules: false }],
    require.resolve('babel-preset-react')
  ]
};
