<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<?php

//Contributions
//This section done by David
// modified by Vien to add JS dynamic loading

//session_start(); //For database error display is session used elsewhere
require_once 'Config.php';
require_once 'Database.php';

try {
    $db = new Database(Config::$db);
} catch (Exception $e) {
    $error = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Game History – Blackjack Royale</title>
  <link rel="stylesheet" href="styles/main.css">
</head>
<body>
<header><h1>Game History</h1></header>
<main>
  <?php if (!empty($error)): ?>
    <p style="color:red;">DB error: <?=htmlspecialchars($error)?></p>
  <?php else: ?>
    <!-- Sprint 4: Button to load history dynamically -->
    <button id="loadHistory">Load History</button>

    <!-- Table body to be filled via JS -->
    <table style="width:100%;border-collapse:collapse;margin-top:1rem;">
      <thead>
        <tr style="background:#175d17;color:#fff;">
          <th style="padding:0.5rem;">Player</th>
          <th style="padding:0.5rem;">Outcome</th>
          <th style="padding:0.5rem;">Player Total</th>
          <th style="padding:0.5rem;">Dealer Total</th>
          <th style="padding:0.5rem;">When</th>
        </tr>
      </thead>
      <tbody id="history-table-body">
        <!-- JS will populate this -->
      </tbody>
    </table>
  <?php endif; ?>

  <a href="index.php?action=home" class="btn">Back to Home</a>
</main>

<!-- Link to your main.js (or home.js if you prefer) -->
<script src="main.js"></script>
</body>
</html>