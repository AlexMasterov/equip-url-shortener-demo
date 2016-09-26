const path = require('path');

function rootDir(...dirs) {
  const rootDir = process.cwd();
  return path.join(rootDir, ...dirs);
}

module.exports = {
  root: rootDir(),
  source: rootDir('src'),
  dist: rootDir('../', 'public'),
  assets: rootDir('../', 'public', 'assets'),
  cache: rootDir('webpack', '.cache'),
  nodeModules: rootDir('node_modules')
};
