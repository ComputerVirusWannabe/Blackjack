<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="contributions" content="File made by Vien, contributions section added by David">
  <title>Blackjack Royale</title>
  <link rel="stylesheet" href="styles/main.css" />
</head>
<body>
  <header>
    <h1>Blackjack Royale</h1>
  </header>

  <main>
    <p>Welcome to the ultimate blackjack experience!</p>

    <h2>Enter Your Name to Begin</h2>

    <!-- Added id="nameForm" for JS to attach listeners -->
    <form id="nameForm" method="POST" action="index.php?action=home">
      <label for="playerName">Player Name:</label><br>
      <!-- name="username" keeps PHP backend happy -->
      <input id="playerName" name="username" type="text" placeholder="Your Name">
      <br>

      <button type="submit" id="startBtn">Play Now</button>
      <a href="index.php?action=rules" class="btn">Rules</a>

      <!-- Error box for client-side validation -->
      <div class="error-box"></div>
    </form>

    <!-- Server side error fallback -->
    <?php if (!empty($error)): ?>
      <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
  </main>

  <footer>
    <p>&copy; 2025 Blackjack Game</p>
  </footer>
  <script src="home.js"></script>
</body>
</html>
