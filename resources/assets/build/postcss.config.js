/* eslint-disable */

const cssnanoConfig = {
  preset: ['default', { discardComments: { removeAll: true } }]
};

const uncssConfig = {
  html: [
    'http://example.test',
    // Your entire sitemap added manually
  ]
};

module.exports = ({ file, options }) => {
  return {
    parser: options.enabled.optimize ? 'postcss-safe-parser' : undefined,
    plugins: {
      'postcss-uncss': options.enabled.optimize ? uncssConfig : false,
      cssnano: options.enabled.optimize ? cssnanoConfig : false,
      autoprefixer: true,
    },
  };
};