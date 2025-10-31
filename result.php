<?php

//Contributions
//Initial code done by Vien
//html changed to php by Vien
//Connection to database done by David
//Bugs fixed by both

//session_start();
if (!file_exists('functions.php')) {
    die("ERROR: functions.php not found. Check file path.");
}
require_once 'functions.php';
require_once 'Config.php';
require_once 'Database.php';

$playerHand = $_SESSION['playerHand'] ?? [];
$dealerHand = $_SESSION['dealerHand'] ?? [];

if (empty($playerHand) || empty($dealerHand)) {
    //result.php was accessed directly
    header('Location: index.php?action=home');
    exit; //block direct access for security
}

$outcome    = checkWinner($playerHand, $dealerHand);

try {
    $db = new Database(Config::$db);
    $stmt = $db->prepare("
        INSERT INTO game_results
            (player_name, player_hand, dealer_hand, player_total, dealer_total, outcome)
        VALUES
            (?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([
        $_SESSION['playerName'] ?? 'Guest',
        implode(',', $playerHand),
        implode(',', $dealerHand),
        calculateTotal($playerHand),
        calculateTotal($dealerHand),
        $outcome
    ]); //persist game result
} catch (Exception $e) {
    error_log('DB insert failed: ' . $e->getMessage());
}

// Clear session for next round
unset($_SESSION['deck'], $_SESSION['playerHand'], $_SESSION['dealerHand']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blackjack Result</title>
  <link rel="stylesheet" href="styles/main.css">
</head>
<body>
<header><h1>Blackjack Royale</h1></header>
<main class="result-container">
    <h2>Game Over!</h2>
    <p>
        <?php
$messages = [
    'win'  => 'You Win!',
    'lose' => 'You Lose!',
    'tie'  => 'It\'s a Tie!'
];
echo $messages[$outcome] ?? 'Unknown Result';
?>
    </p>
    <div class="summary">
        <p>Player Hand: <?php echo implode(' ', $playerHand); ?></p>
        <p>Dealer Hand: <?php echo implode(' ', $dealerHand); ?></p>
    </div>
    <a href="index.php?action=home" class="btn">Play Again</a>
    <a href="index.php?action=history" class="btn">Game History</a>
</main>
</body>
</html>