// resources/js/games/memory-game/index.js
// Dansk Memory Game - ES6 module for Laravel app
// Handles all game logic, DOM updates, and event binding

// --- DOM Elements ---
const topicForm = document.getElementById('topicForm');
const topicSelect = document.getElementById('topicSelect');
const startGameButton = document.getElementById('startGameButton');
const gameBoard = document.getElementById('gameBoard');
const movesCounter = document.getElementById('movesCounter');
const pairsCounter = document.getElementById('pairsCounter');
const totalPairsDisplay = document.getElementById('totalPairsDisplay');
const resetButton = document.getElementById('resetButton');
const winModal = document.getElementById('winModal');
const finalMoves = document.getElementById('finalMoves');
const playAgainButton = document.getElementById('playAgainButton');
const newTopicButton = document.getElementById('newTopicButton');

// --- Global Game State Variables ---
let currentTerms = []; // Holds the terms for the current game
let firstCard = null;
let secondCard = null;
let lockBoard = false;
let moves = 0;
let matchedPairs = 0;
let totalPairs = 0;

// --- Initial Setup ---
document.addEventListener('DOMContentLoaded', () => {
  // If terms are pre-loaded by Blade (because a topic URL was visited directly)
  if (window.memoryGameTerms && window.memoryGameTerms.length > 0) {
    currentTerms = window.memoryGameTerms.map(term => ({ da: term.da, en: term.en }));
    totalPairs = currentTerms.length;
    initializeGame(currentTerms);
    if(resetButton) resetButton.style.display = 'inline-block';
    if(startGameButton) startGameButton.textContent = 'Genstart Spil Med Dette Emne';
    // Ensure the topic select dropdown reflects the current topic
    if (topicSelect && window.selectedTopicSlug) {
        topicSelect.value = window.selectedTopicSlug;
    }
  } else if (gameBoard) {
    // Default message if no topic is pre-loaded
    gameBoard.innerHTML = "<p class='text-slate-500 col-span-full text-center py-10'>Vælg et emne og tryk på 'Start Spil' for at begynde.</p>";
  }

  // --- Event Listeners ---
  if (topicForm) {
    topicForm.addEventListener('submit', function(event) {
      event.preventDefault();
      const selectedTopic = topicSelect.value;
      if (selectedTopic && selectedTopic !== 'default') {
        // Navigate to the new route for the selected topic
        window.location.href = `/memory-game/${selectedTopic}`;
      } else {
        if(gameBoard) gameBoard.innerHTML = '<p class="text-orange-600 col-span-full text-center py-10">Vælg venligst et gyldigt emne.</p>';
      }
    });
  }

  if (resetButton) {
    resetButton.addEventListener('click', () => {
      if (currentTerms.length > 0) {
        initializeGame(currentTerms); // Re-initialize with the same terms
      }
    });
  }

  if (playAgainButton) {
    playAgainButton.addEventListener('click', () => {
      winModal.style.display = 'none';
      if (currentTerms.length > 0) {
        initializeGame(currentTerms); // Re-initialize with the same terms
      }
    });
  }

  if (newTopicButton) {
    newTopicButton.addEventListener('click', () => {
      // Navigate to the main memory game page to select a new topic
      window.location.href = '/memory-game';
    });
  }
});

// --- Core Game Logic Functions ---
function createCardElement(item) {
  const cardDiv = document.createElement('div');
  cardDiv.className = 'card p-0 bg-transparent w-full aspect-[3/2] rounded-lg cursor-pointer relative transition-transform duration-500 ease-in-out';
  cardDiv.dataset.pairId = item.pairId;
  cardDiv.dataset.value = item.value;

  const contentDiv = document.createElement('div');
  contentDiv.className = 'memory-card-content w-full h-full relative rounded-lg shadow-md';

  const cardBackDiv = document.createElement('div');
  cardBackDiv.className = 'memory-card-back absolute w-full h-full top-0 left-0 flex items-center justify-center p-2 box-border rounded-lg text-center bg-blue-500 text-white text-3xl';
  cardBackDiv.textContent = '?';

  const cardFrontDiv = document.createElement('div');
  cardFrontDiv.className = 'memory-card-front absolute w-full h-full top-0 left-0 flex items-center justify-center p-2 box-border rounded-lg text-center bg-slate-200 text-slate-700 text-xs sm:text-sm';
  cardFrontDiv.textContent = item.value;

  contentDiv.appendChild(cardBackDiv);
  contentDiv.appendChild(cardFrontDiv);
  cardDiv.appendChild(contentDiv);

  cardDiv.addEventListener('click', () => flipCard(cardDiv));
  return cardDiv;
}

function initializeGame(termsArray) {
  moves = 0;
  matchedPairs = 0;
  firstCard = null;
  secondCard = null;
  lockBoard = false;
  if(winModal) winModal.style.display = 'none';

  // Ensure currentTerms is correctly populated for resets/replays
  if (termsArray && termsArray.length > 0) {
    currentTerms = termsArray.map(term => ({ da: term.da, en: term.en })); // Make a fresh copy if needed
    totalPairs = currentTerms.length;
  } else if (window.memoryGameTerms && window.memoryGameTerms.length > 0) {
    // Fallback for direct load if termsArray isn't passed explicitly on reset
    currentTerms = window.memoryGameTerms.map(term => ({ da: term.da, en: term.en }));
    totalPairs = currentTerms.length;
  }

  updateCounters(); // Update counters with totalPairs

  if (!currentTerms || currentTerms.length === 0) {
    if(gameBoard) gameBoard.innerHTML = '<p class="text-red-500 col-span-full text-center py-10">Ingen ord at vise. Vælg et emne.</p>';
    if(resetButton) resetButton.style.display = 'none';
    return;
  }

  let gameCardsData = [];
  currentTerms.forEach((term, index) => {
    gameCardsData.push({ value: term.da, pairId: index, type: 'danish' });
    gameCardsData.push({ value: term.en, pairId: index, type: 'english' });
  });
  shuffle(gameCardsData);

  if(gameBoard) {
    gameBoard.innerHTML = ''; // Clear previous cards
    // const numCards = gameCardsData.length; // This variable is no longer needed here
    // The dynamic className assignments for gameBoard based on numCards have been removed
    // to allow Tailwind classes from the Blade template to control responsiveness.

    gameCardsData.forEach(item => {
      const cardElement = createCardElement(item);
      gameBoard.appendChild(cardElement);
    });
  }
  if(resetButton) resetButton.style.display = 'inline-block';
}

function shuffle(array) {
  for (let i = array.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [array[i], array[j]] = [array[j], array[i]];
  }
}

function flipCard(clickedCard) {
  console.log('flipCard called', clickedCard); // DEBUG: log when a card is clicked
  if (lockBoard || clickedCard.classList.contains('is-matched') || clickedCard === firstCard || clickedCard.classList.contains('is-flipped')) return;
  clickedCard.classList.add('is-flipped');
  if (!firstCard) {
    firstCard = clickedCard;
    return;
  }
  secondCard = clickedCard;
  moves++;
  updateCounters();
  checkForMatch();
}

function checkForMatch() {
  lockBoard = true;
  const isMatch = firstCard.dataset.pairId === secondCard.dataset.pairId;
  if (isMatch) {
    disableCards();
  } else {
    unflipCards();
  }
}

function disableCards() {
  firstCard.classList.add('is-matched');
  secondCard.classList.add('is-matched');
  const firstCardFront = firstCard.querySelector('.card-front');
  const secondCardFront = secondCard.querySelector('.card-front');
  if(firstCardFront) firstCardFront.classList.add('bg-green-200', 'text-green-700', 'border-green-400', 'border');
  if(secondCardFront) secondCardFront.classList.add('bg-green-200', 'text-green-700', 'border-green-400', 'border');
  matchedPairs++;
  updateCounters();
  resetBoardStateVars();
  if (matchedPairs === totalPairs) {
    showWinModal();
  }
}

function unflipCards() {
  setTimeout(() => {
    if (firstCard) firstCard.classList.remove('is-flipped');
    if (secondCard) secondCard.classList.remove('is-flipped');
    resetBoardStateVars();
  }, 1000);
}

function resetBoardStateVars() {
  [firstCard, secondCard] = [null, null];
  lockBoard = false;
}

function updateCounters() {
  movesCounter.textContent = moves;
  pairsCounter.textContent = matchedPairs;
  totalPairsDisplay.textContent = totalPairs;
}

function showWinModal() {
  finalMoves.textContent = moves;
  winModal.style.display = 'flex';
}
