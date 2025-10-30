<?php
$playerHand = $_SESSION['playerHand'] ?? [];
$dealerHand = $_SESSION['dealerHand'] ?? [];
$outcome = checkWinner($playerHand, $dealerHand);

// Clear game state for next round
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
        if ($outcome === 'win') echo "You Win!";
        elseif ($outcome === 'lose') echo "You Lose!";
        else echo "It's a Tie!";
        ?>
    </p>
    <div class="summary">
        <p>Player Hand: <?php echo implode(' ', $playerHand); ?></p>
        <p>Dealer Hand: <?php echo implode(' ', $dealerHand); ?></p>
    </div>
    <a href="index.php?action=home" class="btn">Play Again</a>
</main>
</body>
</html>
