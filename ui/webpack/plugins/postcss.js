const LoaderOptionsPlugin = require('webpack').LoaderOptionsPlugin;
const paths = require('../paths');

const postcssPlugins = [
  require('postcss-autoreset')({
    reset: {
      margin: 0,
      padding: 0,
      borderRadius: 0,
      boxSizing: 'border-box'
    }
  }),
  require('cssnano')({
    safe: true,
    autoprefixer: {
      add: true,
      remove: true,
      cascade: false,
      browsers: [
        'last 2 versions',
        'IE > 8'
      ]
    }
  })
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
