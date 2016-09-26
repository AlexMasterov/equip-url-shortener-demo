const ExtractTextPlugin = require('extract-text-webpack-plugin');
const paths = require('../paths');

function json(options = {}) {
  return JSON.stringify(options);
}

let extractTextLoader = ExtractTextPlugin.extract({
  fallbackLoader: 'style',
  loader: [
    `css?${json({
      modules: true,
      importLoaders: 1,
      localIdentName: '[hash:base64:5]'
    })}`,
    `postcss?${json({
      parser: 'sugarss'
    })}`
  ]
});

module.exports = (config) => {
  config.resolve.extensions = [
    ...config.resolve.extensions,
    '.sss'
  ];

  config.plugins = [
    ...config.plugins,
    new ExtractTextPlugin({
      allChunks: true,
      filename: `assets/css/styles-[contenthash:8].css`
    })
  ];

  config.module.loaders = [
    ...config.module.loaders,
    {
      test: /\.sss$/,
      include: paths.source,
      loader: extractTextLoader
    }
  ];

  return config;
};
