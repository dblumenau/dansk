import { gameState, updateGameState, resetGameState } from './gameState.js';
import { startCountdown, clearCountdown } from './autoAdvance.js';

// Utility: Shuffle array (Fisher-Yates)
const shuffleArray = (array) => {
  let arr = array.slice();
  for (let i = arr.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [arr[i], arr[j]] = [arr[j], arr[i]];
  }
  return arr;
};

// UI element selectors
const scoreDisplay = document.getElementById('score-display');
const livesDisplay = document.getElementById('lives-display');
const nounArea = document.getElementById('noun-presentation-area');
const draggableNoun = document.getElementById('draggable-noun');
const currentDanishNoun = document.getElementById('current-danish-noun');
const currentEnglishNoun = document.getElementById('current-english-noun');
const enZone = document.getElementById('en-zone');
const etZone = document.getElementById('et-zone');
const feedbackArea = document.getElementById('feedback-area');
const startButton = document.getElementById('start-button');
const nextWordButton = document.getElementById('next-word-button');
const gameOverModal = document.getElementById('game-over-modal');
const finalScoreModal = document.getElementById('final-score-modal');
const restartButtonModal = document.getElementById('restart-button-modal');

// Game initialization
const init = () => {
  // Debug: log the noun data from Blade
  console.log('window.danishNounData:', window.danishNounData);
  const nouns = window.danishNounData || [];
  updateGameState({ nouns: shuffleArray(nouns) });
  console.log('gameState.nouns after init:', gameState.nouns);
  bindUIEvents();
  updateUI();
};

const startGame = () => {
  resetGameState();
  updateGameState({
    nouns: shuffleArray(gameState.nouns),
    gameStatus: 'playing'
  });
  updateUI();
  displayNextNoun();
};

const displayNextNoun = () => {
  clearCountdown();
  updateGameState({ gameStatus: 'playing' }); // Reset status for new noun
  if (gameState.currentNounIndex < gameState.nouns.length) {
    const noun = gameState.nouns[gameState.currentNounIndex];
    console.log('displayNextNoun noun:', noun); // Debug: log the noun object
    updateGameState({ currentNoun: noun });
    currentDanishNoun.textContent = noun.danish;
    currentEnglishNoun.textContent = noun.english;
    draggableNoun.setAttribute('aria-grabbed', 'false');
    feedbackArea.textContent = '';
    nextWordButton.classList.add('hidden');
    draggableNoun.focus();
  } else {
    endGame();
  }
};

const checkAnswer = (chosenGender) => {
  const noun = gameState.currentNoun;
  if (!noun) return;
  // Prevent multiple answers for the same noun
  if (gameState.gameStatus === 'correct' || gameState.gameStatus === 'incorrect') return;
  let wasCorrect = false;
  if (noun.gender === chosenGender) {
    updateGameState({
      score: gameState.score + 10,
      gameStatus: 'correct',
      currentNounIndex: gameState.currentNounIndex + 1
    });
    updateFeedbackUI('Correct!', true);
    updateScoreboardUI();
    wasCorrect = true;
  } else {
    updateGameState({
      lives: gameState.lives - 1,
      gameStatus: 'incorrect'
    });
    updateFeedbackUI(`Incorrect. '${noun.danish}' is '${noun.gender}'.`, false);
    updateScoreboardUI();
    wasCorrect = false;
  }
  // Hide next button, start countdown
  nextWordButton.classList.add('hidden');
  startCountdown(() => {
    console.log('Countdown callback triggered');
    const { lives, currentNounIndex, nouns } = gameState;
    console.log('Current state:', { lives, currentNounIndex, nouns: nouns.length });

    if (lives <= 0 || currentNounIndex >= nouns.length - 1) {
      console.log('Ending game...');
      endGame();
    } else {
      console.log('Advancing to next noun...');
      updateGameState({
        currentNounIndex: currentNounIndex + 1,
        gameStatus: 'playing'
      });
      displayNextNoun();
      // Reset game status and advance to next noun
      updateGameState({ gameStatus: 'playing' });
      displayNextNoun();
    }
  }, 5);
};

const updateFeedbackUI = (message, isCorrect) => {
  feedbackArea.textContent = message;
  feedbackArea.className = isCorrect
    ? 'text-center h-10 mb-6 text-xl font-medium text-green-600'
    : 'text-center h-10 mb-6 text-xl font-medium text-red-600';
};

const updateScoreboardUI = () => {
  scoreDisplay.textContent = gameState.score;
  livesDisplay.textContent = gameState.lives;
};

const updateUI = () => {
  updateScoreboardUI();
  if (gameState.gameStatus === 'gameOver') {
    gameOverModal.classList.remove('hidden');
    finalScoreModal.textContent = gameState.score;
  } else {
    gameOverModal.classList.add('hidden');
  }
};

const endGame = () => {
  updateGameState({ gameStatus: 'gameOver' });
  updateUI();
};

// Drag and drop handlers
const handleDragStart = (e) => {
  e.dataTransfer.setData('text/plain', gameState.currentNoun.id);
  updateGameState({ isDragging: true });
  draggableNoun.setAttribute('aria-grabbed', 'true');
};

const handleDragEnd = () => {
  updateGameState({ isDragging: false });
  draggableNoun.setAttribute('aria-grabbed', 'false');
};

const handleDragOver = (e) => {
  e.preventDefault();
};

const handleDrop = (e, gender) => {
  e.preventDefault();
  checkAnswer(gender);
  handleDragEnd();
};

// Keyboard controls
const handleKeyboardChoice = (e) => {
  if (gameState.gameStatus !== 'playing') return;
  if (e.key === 'ArrowLeft' || e.key.toLowerCase() === 'e' || e.key === '1') {
    checkAnswer('en');
  } else if (e.key === 'ArrowRight' || e.key.toLowerCase() === 't' || e.key === '2') {
    checkAnswer('et');
  }
};

const bindUIEvents = () => {
  startButton.addEventListener('click', startGame);
  nextWordButton.addEventListener('click', () => {
    nextWordButton.classList.add('hidden');
    displayNextNoun();
  });
  restartButtonModal.addEventListener('click', () => {
    gameOverModal.classList.add('hidden');
    startGame();
  });
  draggableNoun.addEventListener('dragstart', handleDragStart);
  draggableNoun.addEventListener('dragend', handleDragEnd);
  draggableNoun.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' || e.key === ' ') {
      draggableNoun.classList.add('ring-2', 'ring-sky-500');
    }
    handleKeyboardChoice(e);
  });
  enZone.addEventListener('dragover', handleDragOver);
  etZone.addEventListener('dragover', handleDragOver);
  enZone.addEventListener('drop', (e) => handleDrop(e, 'en'));
  etZone.addEventListener('drop', (e) => handleDrop(e, 'et'));
  enZone.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' || e.key === ' ') checkAnswer('en');
  });
  etZone.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' || e.key === ' ') checkAnswer('et');
  });
  enZone.addEventListener('click', (e) => {
    e.preventDefault();
    if (gameState.gameStatus === 'playing') checkAnswer('en');
  });
  etZone.addEventListener('click', (e) => {
    e.preventDefault();
    if (gameState.gameStatus === 'playing') checkAnswer('et');
  });
};

// Auto-init if on correct page
if (document.getElementById('game-noun-sorter-container')) {
  window.addEventListener('DOMContentLoaded', init);
}
