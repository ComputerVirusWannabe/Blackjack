<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
    <form method="POST" action="index.php?action=home">
      <label>Player Name:</label><br>
      <input type="text" name="username" placeholder="Your Name" required>
      <br>
      <button type="submit">Play Now</button>
      <a href="index.php?action=rules" class="btn">Rules</a>
    </form>
    
    <?php if (!empty($error)): ?>
      <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>
  </main>

  <footer>
    <p>&copy; 2025 Blackjack Game</p>
  </footer>
</body>
</html>
