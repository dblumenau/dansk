/** @type {import('@commitlint/types').UserConfig} */
module.exports = {
  extends: ['@commitlint/config-conventional'],
  rules: {
    'type-enum': [
      2,
      'always',
      [
        'feat', // New features
        'fix', // Bug fixes
        'docs', // Updates to the README, documentation, or comments
        'style', // Code style changes (formatting, whitespace, etc.)
        'refactor', // Refactoring code without changing functionality
        'test', // Adding or updating tests
        'chore', // Build tasks, configs, etc.
        'idea', // Experimental or speculative commits
        'explore', // Temporary commits for exploration or learning
        'tantrum', // Your sacred rage deserves recognition
      ],
    ],
    'scope-case': [2, 'always', 'kebab-case'],
    'subject-case': [0], // disable enforcement of sentence case
  },
};
