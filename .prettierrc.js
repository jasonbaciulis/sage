module.exports = {
  printWidth: 90,
  bracketSpacing: true,
  jsxBracketSameLine: true,
  trailingComma: 'es5',
  singleQuote: true,
  overrides: [
    {
      files: ['*.scss', '*.css'],
      options: {
        singleQuote: false,
      },
    },
  ],
};
