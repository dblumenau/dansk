// Countdown animation and auto-advance logic for Noun Gender Sorter
let countdownInterval = null;
let countdownTimeout = null;

export const clearCountdown = () => {
  if (countdownInterval) clearInterval(countdownInterval);
  if (countdownTimeout) clearTimeout(countdownTimeout);
  countdownInterval = null;
  countdownTimeout = null;
  // Optionally clear countdown UI
  const el = document.getElementById('countdown-indicator');
  if (el) el.remove();
};

export const startCountdown = (onFinish, seconds = 5) => {
  clearCountdown(); // Clear any existing countdown
  console.log('Starting countdown...');
  const feedbackArea = document.getElementById('feedback-area');
  let remaining = seconds;
  updateCountdownUI(feedbackArea, remaining);

  countdownInterval = setInterval(() => {
    remaining--;
    console.log(`Countdown: ${remaining}`);
    if (remaining <= 0) {
      clearInterval(countdownInterval);
      updateCountdownUI(feedbackArea, 0);
    } else {
      updateCountdownUI(feedbackArea, remaining);
    }
  }, 1000);
  countdownTimeout = setTimeout(() => {
    console.log('Countdown finished, calling onFinish...');
    clearCountdown();
    if (typeof onFinish === 'function') {
      onFinish();
    }
  }, seconds * 1000);
};

function updateCountdownUI(feedbackArea, remaining) {
  let el = document.getElementById('countdown-indicator');
  if (!el) {
    el = document.createElement('span');
    el.id = 'countdown-indicator';
    el.className = 'ml-3 inline-block text-base font-bold text-sky-600 animate-pulse';
    feedbackArea.appendChild(el);
  }
  el.textContent = `Next in ${remaining}...`;
}
