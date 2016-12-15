const defaultConfig = {
  safe: true,
  sourcemap: false,
  mergeIdents: false,
  reduceIdents: false,
  discardUnused: false,
  discardComments: {
    removeAll: true
  },
  autoprefixer: {
    add: true,
    remove: true,
    cascade: false,
    browsers: [
      'last 2 versions',
      'IE > 8'
    ]
  }
};

module.exports = (newConfig = {}) => {
  return require('cssnano')(
    Object.assign(defaultConfig, newConfig)
  );
};
