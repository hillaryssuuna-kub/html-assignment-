// JS Developer — Group B

const correctAnswers = [
    "Central Processing Unit",
    "RAM",
    "Manage hardware and software resources",
    "Binary(Base 2)",
    "Hyper Text Markup Language",
    "Modem",
    "Uniquely identify a device on a network",
    "Keyboard",
    "To repeat a block of code multiple times",
    "HyperText Transfer Protocol"
];

let timerInterval = null;
let timeLeft = 150; // 2 minutes 30 seconds
let quizStarted = false;

const timerEl  = document.getElementById('timer');
const startBtn = document.getElementById('start-btn');

// ── TIMER ──────────────────────────────────────────
function formatTime(seconds) {
    const m = Math.floor(seconds / 60).toString().padStart(2, '0');
    const s = (seconds % 60).toString().padStart(2, '0');
    return `Time Left: ${m}:${s}`;
}

startBtn.addEventListener('click', () => {
    if (quizStarted) return;
    quizStarted = true;
    startBtn.disabled = true;

    timerInterval = setInterval(() => {
        timeLeft--;
        timerEl.textContent = formatTime(timeLeft);

        if (timeLeft <= 30) {
            timerEl.className = 'danger';
        } else if (timeLeft <= 60) {
            timerEl.className = 'warning';
        }

        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            // Time's up — calculate score and submit form
            calculateAndSubmit(true);
        }
    }, 1000);
});

// ── SCORE CALCULATION ──────────────────────────────
function calculateScore() {
    let score = 0;
    for (let i = 1; i <= 10; i++) {
        const selected = document.querySelector(`input[name="q${i}"]:checked`);
        if (selected && selected.value === correctAnswers[i - 1]) {
            score++;
        }
    }
    return score;
}

function calculateAndSubmit(autoSubmit = false) {
    clearInterval(timerInterval);

    const score = calculateScore();

    // Write score into the hidden form field so PHP receives it
    document.getElementById('score-hidden').value = score;

    if (autoSubmit) {
        document.getElementById('quiz-form').submit();
    }
}

// ── SUBMIT BUTTON ──────────────────────────────────
document.getElementById('quiz-form').addEventListener('submit', (e) => {
    const name = document.getElementById('player-name-input').value.trim();

    if (!name) {
        e.preventDefault();
        alert('Please enter your name before submitting!');
        return;
    }

    // Calculate score and fill hidden field, then let the form post to scores.php
    calculateAndSubmit(false);
});
