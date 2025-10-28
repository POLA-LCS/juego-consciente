let balance = 1000;
let currentBet = 10;
let deck = [];
let playerCards = [];
let dealerCards = [];
let gameStarted = false;

const suits = ['♠', '♥', '♦', '♣'];
const values = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];

function createDeck() {
    deck = [];
    for (let suit of suits) {
        for (let value of values) {
            deck.push({ suit, value });
        }
    }
    shuffleDeck();
}

function shuffleDeck() {
    for (let i = deck.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [deck[i], deck[j]] = [deck[j], deck[i]];
    }
}

function getCardValue(card) {
    if (card.value === 'A') return 11;
    if (['J', 'Q', 'K'].includes(card.value)) return 10;
    return parseInt(card.value);
}

function calculateScore(cards) {
    let score = 0;
    let aces = 0;
    for (let card of cards) {
        score += getCardValue(card);
        if (card.value === 'A') aces++;
    }
    while (score > 21 && aces > 0) {
        score -= 10;
        aces--;
    }
    return score;
}

function renderCards(cards, containerId) {
    const container = document.getElementById(containerId);
    container.innerHTML = '';
    for (let card of cards) {
        const cardDiv = document.createElement('div');
        cardDiv.className = 'card';
        cardDiv.textContent = card.value + card.suit;
        container.appendChild(cardDiv);
    }
}

function updateScores() {
    document.getElementById('playerScore').textContent = 'Puntuación: ' + calculateScore(playerCards);
    document.getElementById('dealerScore').textContent = 'Puntuación: ' + calculateScore(dealerCards);
}

function startGame() {
    createDeck();
    playerCards = [deck.pop(), deck.pop()];
    dealerCards = [deck.pop(), deck.pop()];
    renderCards(playerCards, 'playerCards');
    renderCards(dealerCards, 'dealerCards');
    updateScores();
    gameStarted = true;
    document.getElementById('hit').disabled = false;
    document.getElementById('stand').disabled = false;
    document.getElementById('placeBet').disabled = true;
}

function hit() {
    playerCards.push(deck.pop());
    renderCards(playerCards, 'playerCards');
    updateScores();
    if (calculateScore(playerCards) > 21) {
        endGame('Perdiste');
    }
}

function stand() {
    while (calculateScore(dealerCards) < 17) {
        dealerCards.push(deck.pop());
    }
    renderCards(dealerCards, 'dealerCards');
    updateScores();
    const playerScore = calculateScore(playerCards);
    const dealerScore = calculateScore(dealerCards);
    if (dealerScore > 21 || playerScore > dealerScore) {
        endGame('Ganaste');
    } else if (playerScore === dealerScore) {
        endGame('Empate');
    } else {
        endGame('Perdiste');
    }
}

function endGame(result) {
    document.getElementById('message').textContent = result;
    gameStarted = false;
    document.getElementById('hit').disabled = true;
    document.getElementById('stand').disabled = true;
    document.getElementById('placeBet').disabled = false;
    // Update balance based on result
    if (result === 'Ganaste') {
        balance += currentBet;
    } else if (result === 'Perdiste') {
        balance -= currentBet;
    }
    document.getElementById('balance').textContent = balance;
}

// Event listeners
document.getElementById('minus1').addEventListener('click', () => { if (currentBet > 1) currentBet -= 1; document.getElementById('currentBet').textContent = currentBet; });
document.getElementById('minus10').addEventListener('click', () => { if (currentBet > 10) currentBet -= 10; document.getElementById('currentBet').textContent = currentBet; });
document.getElementById('minus100').addEventListener('click', () => { if (currentBet > 100) currentBet -= 100; document.getElementById('currentBet').textContent = currentBet; });
document.getElementById('plus1').addEventListener('click', () => { currentBet += 1; document.getElementById('currentBet').textContent = currentBet; });
document.getElementById('plus10').addEventListener('click', () => { currentBet += 10; document.getElementById('currentBet').textContent = currentBet; });
document.getElementById('plus100').addEventListener('click', () => { currentBet += 100; document.getElementById('currentBet').textContent = currentBet; });
document.getElementById('resetBet').addEventListener('click', () => { currentBet = 10; document.getElementById('currentBet').textContent = currentBet; });
document.getElementById('placeBet').addEventListener('click', () => { if (balance >= currentBet) startGame(); });
document.getElementById('hit').addEventListener('click', hit);
document.getElementById('stand').addEventListener('click', stand);

// Load balance on page load
document.addEventListener('DOMContentLoaded', () => {
    // Fetch balance from server
    fetch('../../../app/controllers/UserController.php?action=getBalance&game=blackjack')
        .then(response => response.text())
        .then(data => {
            balance = parseInt(data);
            document.getElementById('balance').textContent = balance;
        });
});
