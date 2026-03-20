
/* ═══════════════════════════════════════════════════════
   GAMEBOARD  (IIFE – single instance)
═══════════════════════════════════════════════════════ */
const Gameboard = (() => {
  let board = Array(9).fill(null);

  const getBoard  = () => [...board];
  const getCell   = (i) => board[i];
  const setCell   = (i, mark) => { if (board[i] === null) { board[i] = mark; return true; } return false; };
  const reset     = () => { board = Array(9).fill(null); };

  return { getBoard, getCell, setCell, reset };
})();


/* ═══════════════════════════════════════════════════════
   PLAYER  (factory)
═══════════════════════════════════════════════════════ */
const createPlayer = (name, mark) => {
  let wins = 0;
  const addWin  = () => wins++;
  const getWins = () => wins;
  const resetWins = () => { wins = 0; };
  return { name, mark, addWin, getWins, resetWins };
};


/* ═══════════════════════════════════════════════════════
   GAME CONTROLLER  (IIFE – single instance)
═══════════════════════════════════════════════════════ */
const GameController = (() => {
  const WIN_LINES = [
    [0,1,2],[3,4,5],[6,7,8], // rows
    [0,3,6],[1,4,7],[2,5,8], // cols
    [0,4,8],[2,4,6],         // diags
  ];

  let players   = [];
  let currentIdx = 0;
  let ties      = 0;
  let gameOver  = false;

  const init = (p1, p2) => {
    players    = [p1, p2];
    currentIdx = 0;
    ties       = 0;
    gameOver   = false;
    Gameboard.reset();
  };

  const resetRound = () => {
    currentIdx = 0;
    gameOver   = false;
    Gameboard.reset();
  };

  const getCurrentPlayer = () => players[currentIdx];
  const getTies          = () => ties;
  const isGameOver       = () => gameOver;

  const checkWinner = () => {
    const b = Gameboard.getBoard();
    for (const [a, c, d] of WIN_LINES) {
      if (b[a] && b[a] === b[c] && b[a] === b[d]) return { winner: b[a], line: [a, c, d] };
    }
    if (b.every(cell => cell !== null)) return { winner: null, tie: true };
    return null;
  };

  const playTurn = (index) => {
    if (gameOver) return { status: 'over' };
    const player = getCurrentPlayer();
    const placed = Gameboard.setCell(index, player.mark);
    if (!placed) return { status: 'invalid' };

    const result = checkWinner();
    if (result) {
      gameOver = true;
      if (result.tie) {
        ties++;
        return { status: 'tie' };
      }
      player.addWin();
      return { status: 'win', winner: player, line: result.line };
    }

    currentIdx = 1 - currentIdx;
    return { status: 'continue', nextPlayer: getCurrentPlayer() };
  };

  return { init, resetRound, getCurrentPlayer, getTies, isGameOver, playTurn };
})();


/* ═══════════════════════════════════════════════════════
   DISPLAY CONTROLLER  (IIFE – single instance)
═══════════════════════════════════════════════════════ */
const DisplayController = (() => {
  /* cache DOM nodes */
  const setupPanel  = document.getElementById('setup-panel');
  const gamePanel   = document.getElementById('game-panel');
  const boardEl     = document.getElementById('board');
  const statusEl    = document.getElementById('status');
  const nameXInput  = document.getElementById('name-x');
  const nameOInput  = document.getElementById('name-o');
  const btnStart    = document.getElementById('btn-start');
  const btnNext     = document.getElementById('btn-next');
  const btnReset    = document.getElementById('btn-reset');
  const labelX      = document.getElementById('label-x');
  const labelO      = document.getElementById('label-o');
  const winsXEl     = document.getElementById('wins-x');
  const winsOEl     = document.getElementById('wins-o');
  const tiesLabel   = document.getElementById('ties-label');
  const scoreX      = document.getElementById('score-x');
  const scoreO      = document.getElementById('score-o');

  let players = [];

  /* ── build board cells ── */
  const buildBoard = () => {
    boardEl.innerHTML = '';
    for (let i = 0; i < 9; i++) {
      const cell = document.createElement('div');
      cell.classList.add('cell');
      cell.dataset.index = i;
      cell.innerHTML = '<span class="mark"></span>';
      cell.addEventListener('click', handleCellClick);
      boardEl.appendChild(cell);
    }
  };

  /* ── render board from array ── */
  const renderBoard = () => {
    const board = Gameboard.getBoard();
    const cells = boardEl.querySelectorAll('.cell');
    cells.forEach((cell, i) => {
      const mark = board[i];
      cell.classList.remove('taken','played','x-cell','o-cell','win-cell');
      const markEl = cell.querySelector('.mark');
      if (mark) {
        cell.classList.add('taken', `${mark.toLowerCase()}-cell`);
        markEl.textContent = mark === 'X' ? '✕' : '○';
        // trigger animation on next frame
        requestAnimationFrame(() => cell.classList.add('played'));
      } else {
        markEl.textContent = '';
      }
    });
  };

  /* ── highlight winning cells ── */
  const highlightWin = (line) => {
    const cells = boardEl.querySelectorAll('.cell');
    line.forEach(i => cells[i].classList.add('win-cell'));
  };

  /* ── update status text ── */
  const setStatus = (html) => { statusEl.innerHTML = html; };

  /* ── update scoreboard ── */
  const updateScores = () => {
    const [p1, p2] = players;
    winsXEl.textContent  = p1.getWins();
    winsOEl.textContent  = p2.getWins();
    tiesLabel.textContent = `ties: ${GameController.getTies()}`;
  };

  /* ── highlight active player card ── */
  const setActiveCard = (mark) => {
    scoreX.classList.toggle('active-player', mark === 'X');
    scoreO.classList.toggle('active-player', mark === 'O');
  };

  /* ── cell click handler ── */
  const handleCellClick = (e) => {
    const idx = parseInt(e.currentTarget.dataset.index, 10);
    const result = GameController.playTurn(idx);

    if (result.status === 'invalid' || result.status === 'over') return;

    renderBoard();

    if (result.status === 'win') {
      highlightWin(result.line);
      updateScores();
      setStatus(`<span class="winner">🏆 ${result.winner.name} wins!</span>`);
      setActiveCard(null);
    } else if (result.status === 'tie') {
      updateScores();
      setStatus(`<span class="tie">Draw — no winner this round.</span>`);
      setActiveCard(null);
    } else {
      const next = result.nextPlayer;
      const cls  = next.mark === 'X' ? 'x-turn' : 'o-turn';
      setStatus(`<span class="${cls}">${next.name}'s turn (${next.mark === 'X' ? '✕' : '○'})</span>`);
      setActiveCard(next.mark);
    }
  };

  /* ── start / reset round ── */
  const startRound = () => {
    GameController.resetRound();
    buildBoard();
    renderBoard();
    const cur = GameController.getCurrentPlayer();
    const cls = cur.mark === 'X' ? 'x-turn' : 'o-turn';
    setStatus(`<span class="${cls}">${cur.name}'s turn (${cur.mark === 'X' ? '✕' : '○'})</span>`);
    setActiveCard(cur.mark);
    updateScores();
  };

  /* ── START GAME button ── */
  btnStart.addEventListener('click', () => {
    const nameX = nameXInput.value.trim() || 'Player X';
    const nameO = nameOInput.value.trim() || 'Player O';
    players = [createPlayer(nameX, 'X'), createPlayer(nameO, 'O')];
    GameController.init(players[0], players[1]);

    labelX.textContent = nameX;
    labelO.textContent = nameO;

    setupPanel.classList.add('hidden');
    gamePanel.classList.remove('hidden');

    buildBoard();
    renderBoard();
    const cur = GameController.getCurrentPlayer();
    setStatus(`<span class="x-turn">${cur.name}'s turn (✕)</span>`);
    setActiveCard('X');
    updateScores();
  });

  /* ── NEXT ROUND button ── */
  btnNext.addEventListener('click', startRound);

  /* ── CHANGE PLAYERS button ── */
  btnReset.addEventListener('click', () => {
    players.forEach(p => p.resetWins());
    gamePanel.classList.add('hidden');
    setupPanel.classList.remove('hidden');
    nameXInput.value = '';
    nameOInput.value = '';
  });

  /* allow pressing Enter on name inputs to start */
  [nameXInput, nameOInput].forEach(inp => {
    inp.addEventListener('keydown', e => { if (e.key === 'Enter') btnStart.click(); });
  });
})();
