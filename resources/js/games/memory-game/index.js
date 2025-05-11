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

let currentTerms = [];
let firstCard = null;
let secondCard = null;
let lockBoard = false;
let moves = 0;
let matchedPairs = 0;
let totalPairs = 0;

// --- Event Listeners ---
if (topicForm) {
  topicForm.addEventListener('submit', async function(event) {
    event.preventDefault();
    event.stopPropagation(); // Prevent any default form submission
    const selectedTopic = topicSelect.value;
    if (selectedTopic === 'default') {
      gameBoard.innerHTML = '<p class="text-orange-600 col-span-full text-center py-10">Vælg venligst et gyldigt emne.</p>';
      return;
    }
    startGameButton.disabled = true;
    startGameButton.textContent = 'Henter...';
    gameBoard.innerHTML = `<p class="text-slate-500 col-span-full text-center py-10">Henter ord for emnet: ${selectedTopic}...</p>`;
    resetButton.style.display = 'none';
    try {
      // Always use absolute URL for local API in dev
      console.log('Fetching data from API:', window.location.origin + '/api/memory-terms?topic=' + encodeURIComponent(selectedTopic));
      const apiUrl = window.location.origin + '/api/memory-terms?topic=' + encodeURIComponent(selectedTopic);
      const response = await fetch(apiUrl);
      if (!response.ok) throw new Error(`Netværksfejl: ${response.statusText}`);
      const fetchedData = await response.json();
      if (fetchedData && fetchedData.length > 0) {
        currentTerms = fetchedData.map((term, index) => ({
          da: term.da,
          en: term.en
        }));
        totalPairs = currentTerms.length;
        initializeGame(currentTerms);
        resetButton.style.display = 'inline-block';
      } else {
        gameBoard.innerHTML = `<p class="text-red-500 col-span-full text-center py-10">Ingen ord fundet for dette emne. Prøv emnet 'Jobs & Arbejde'.</p>`;
        resetButton.style.display = 'none';
      }
    } catch (error) {
      gameBoard.innerHTML = `<p class="text-red-500 col-span-full text-center py-10">Fejl ved hentning af ord: ${error.message}</p>`;
    } finally {
      startGameButton.disabled = false;
      startGameButton.textContent = 'Hent Ord & Start Spil';
    }
  });
}

function createCardElement(item) {
  const cardDiv = document.createElement('div');
  cardDiv.className = 'card bg-transparent h-24 rounded-lg cursor-pointer relative transition-transform duration-500 ease-in-out';
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
  updateCounters();
  winModal.style.display = 'none';

  let gameCardsData = [];
  termsArray.forEach((term, index) => {
    gameCardsData.push({ value: term.da, pairId: index, type: 'danish' });
    gameCardsData.push({ value: term.en, pairId: index, type: 'english' });
  });
  shuffle(gameCardsData);

  gameBoard.innerHTML = '';
  const numCards = gameCardsData.length;
  if (numCards <= 12) gameBoard.className = 'game-board grid grid-cols-2 xs:grid-cols-3 sm:grid-cols-4 gap-1 sm:gap-1 p-1 sm:p-2 bg-white rounded-xl shadow-xl min-h-[100px]';
  else if (numCards <= 20) gameBoard.className = 'game-board grid grid-cols-2 xs:grid-cols-3 sm:grid-cols-5 gap-1 sm:gap-1 p-1 sm:p-2 bg-white rounded-xl shadow-xl min-h-[100px]';
  else if (numCards <= 30) gameBoard.className = 'game-board grid grid-cols-2 xs:grid-cols-4 sm:grid-cols-6 gap-1 sm:gap-1 p-1 sm:p-2 bg-white rounded-xl shadow-xl min-h-[100px]';
  else gameBoard.className = 'game-board grid grid-cols-2 xs:grid-cols-4 sm:grid-cols-8 gap-1 sm:gap-1 p-1 sm:p-2 bg-white rounded-xl shadow-xl min-h-[100px]';

  gameCardsData.forEach(item => {
    const cardElement = createCardElement(item);
    gameBoard.appendChild(cardElement);
  });
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

if (resetButton) {
  resetButton.addEventListener('click', () => {
    if (currentTerms.length > 0) {
      initializeGame(currentTerms);
    }
  });
}
if (playAgainButton) {
  playAgainButton.addEventListener('click', () => {
    winModal.style.display = 'none';
    if (currentTerms.length > 0) {
      initializeGame(currentTerms);
    }
  });
}
if (newTopicButton) {
  newTopicButton.addEventListener('click', () => {
    winModal.style.display = 'none';
    gameBoard.innerHTML = "<p class='text-slate-500 col-span-full text-center py-10'>Vælg et emne og tryk på 'Hent Ord & Start Spil' for at begynde.</p>";
    movesCounter.textContent = '0';
    pairsCounter.textContent = '0';
    totalPairsDisplay.textContent = '0';
    resetButton.style.display = 'none';
    topicSelect.value = 'default';
  });
}
