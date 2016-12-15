const LoaderOptionsPlugin = require('webpack').LoaderOptionsPlugin;
const paths = require('../paths');

const postcssPlugins = [
  require('../postcss/autoreset')(),
  require('../postcss/cssnano')()
];

module.exports = (config) => {
  config.plugins = [
    ...config.plugins,
    new LoaderOptionsPlugin({
      options: {
        context: paths.root,
        postcss: postcssPlugins
      }
    })
  ];

  return config;
};
