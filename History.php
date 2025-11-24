<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Game History – Blackjack Royale</title>
  <link rel="stylesheet" href="styles/main.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body data-page="history">
<header><h1>Game History</h1></header>
<main>
  <button id="loadHistory" class="btn">Load History</button>

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
      <tr><td colspan="5" style="text-align:center;padding:2rem;color:#ccc;">Click "Load History" to view past games</td></tr>
    </tbody>
  </table>

  <a href="index.php?action=home" class="btn">Back to Home</a>
</main>

<script src="main.js"></script>
</body>
</html>