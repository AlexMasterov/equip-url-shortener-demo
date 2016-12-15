const defaultConfig = {
  reset: {
    margin: 0,
    padding: 0,
    borderRadius: 0,
    boxSizing: 'border-box'
  }
};

module.exports = (newConfig = {}) => {
  return require('postcss-autoreset')(
    Object.assign(defaultConfig, newConfig)
  );
};
