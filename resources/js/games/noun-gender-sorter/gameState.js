// State management for Danish Noun Gender Sorter
export let gameState = {
  nouns: [], // Array of noun objects: { id, danish, gender, english, audio }
  currentNounIndex: 0,
  currentNoun: null,
  score: 0,
  lives: 3,
  gameStatus: 'initial', // 'initial', 'playing', 'paused', 'correct', 'incorrect', 'gameOver'
  isDragging: false
};

export const updateGameState = (newState) => {
  gameState = { ...gameState, ...newState };
};

export const resetGameState = () => {
  updateGameState({
    currentNounIndex: 0,
    currentNoun: null,
    score: 0,
    lives: 3,
    gameStatus: 'initial',
    isDragging: false
  });
};
