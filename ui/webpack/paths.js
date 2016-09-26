const path = require('path');
const processCwd = process.cwd();

function rootDir(...dirs) {
  return path.join(processCwd, ...dirs);
}

module.exports = {
  root: rootDir(),
  source: rootDir('src'),
  dist: rootDir('../', 'public'),
  assets: rootDir('../', 'public', 'assets'),
  cache: rootDir('webpack', '.cache'),
  nodeModules: rootDir('node_modules')
};
