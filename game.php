<?php

//Contributions
//Made by Vien, post section edited by David for more functionality later

require_once 'functions.php'; //game logic helpers

if (empty($_SESSION['playerHand']) || empty($_SESSION['dealerHand'])) {
    header('Location: index.php?action=home');
    exit; //prevent access without game state, safeguard added during debugging
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name = "contributions" content = "File made by Vien, contributions section and connected to database by David">
  <title>Blackjack Game</title>
  <link rel="stylesheet" href="styles/main.css">
</head>
<body data-page="game">
<header><h1>Blackjack</h1></header>
<main class="game-container">

    <section class="dealer-hand">
        <h2>Dealer</h2>
        <div class="cards">
            <?php foreach ($_SESSION['dealerHand'] as $card): ?>
                <div class="card"><?php echo $card; ?></div>
            <?php endforeach; ?>
        </div>
        <p>Total: <?php echo calculateTotal($_SESSION['dealerHand']); ?></p>
    </section>

    <section class="player-hand">
        <h2><?php echo $_SESSION['playerName'] ?? 'Player'; ?></h2>
        <div class="cards">
            <?php foreach ($_SESSION['playerHand'] as $card): ?>
                <div class="card"><?php echo $card; ?></div>
            <?php endforeach; ?>
        </div>
        <p>Total: <?php echo calculateTotal($_SESSION['playerHand']); ?></p>

        <form method="POST" action="index.php?action=game">
            <input type="hidden" name="playerName" value="<?php echo htmlspecialchars($_SESSION['playerName'] ?? 'Player'); ?>">
            <button type="submit" name="action" value="hit">Hit</button>
            <button type="submit" name="action" value="stand">Stand</button>
        </form>
    </section>
</main>
<script src="main.js"></script>
</body>
</html>