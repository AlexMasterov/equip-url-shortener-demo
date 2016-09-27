const paths = require('../paths');

module.exports = {
  babelrc: false,
  compact: true,
  cacheDirectory: paths.cache,
  presets: [
    [require.resolve('babel-preset-latest'), { modules: false }],
    require.resolve('babel-preset-react')
  ],
  plugins: [
    // class { handleClick = () => { } }
    require.resolve('babel-plugin-transform-class-properties'),
    // { ...todo, completed: true }
    require.resolve('babel-plugin-transform-object-rest-spread')
  ]
};
