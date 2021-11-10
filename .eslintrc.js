module.exports = {
  root: true,
  env: {
    browser: true,
    es2021: true,
  },
  extends: [
    'standard',
  ],
  parserOptions: {
    ecmaVersion: 12,
    sourceType: 'module',
  },
  ignorePatterns: [
    '!.eslintrc.js',
    'node_modules/',
    'public/build/',
  ],
  plugins: [],
  rules: {
    // allow paren-less arrow functions
    'arrow-parens': 0,
    'comma-dangle': [
      'error',
      'always-multiline',
    ],
    // disable conditional assign
    'no-cond-assign': 0,
    // allow async-await
    'generator-star-spacing': 0,
    'newline-before-return': 1,
    // allow debugger during development
    'no-debugger': process.env.NODE_ENV === 'production' ? 2 : 0,
    'no-else-return': 1,
    'padding-line-between-statements': [
      'error',
      { blankLine: 'always', prev: '*', next: 'break' },
      { blankLine: 'always', prev: '*', next: 'case' },
      { blankLine: 'always', prev: '*', next: 'continue' },
      { blankLine: 'always', prev: '*', next: 'default' },
      { blankLine: 'always', prev: '*', next: 'export' },
      { blankLine: 'always', prev: '*', next: 'for' },
      { blankLine: 'always', prev: '*', next: 'if' },
      { blankLine: 'always', prev: '*', next: 'return' },
      { blankLine: 'always', prev: '*', next: 'switch' },
      { blankLine: 'always', prev: '*', next: 'throw' },
      { blankLine: 'always', prev: '*', next: 'try' },
      { blankLine: 'always', prev: '*', next: 'while' },
      { blankLine: 'always', prev: '*', next: ['const', 'let', 'var'] },
      { blankLine: 'always', prev: ['const', 'let', 'var'], next: '*' },
      { blankLine: 'any', prev: ['const', 'let', 'var'], next: ['const', 'let', 'var'] },
    ],
    'sort-imports': [
      'error',
    ],
  },
}
