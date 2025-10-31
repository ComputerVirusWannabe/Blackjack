<?php

//Contributions
//This section done by David

session_start(); //For database error display is session used elsewhere
require_once 'Config.php';
require_once 'Database.php';

try {
    $db = new Database(Config::$db);
    $stmt = $db->query("SELECT * FROM game_results ORDER BY played_at DESC LIMIT 50");
    $games = $stmt->fetchAll(); //fetch recent games
} catch (Exception $e) {
    $games = [];
    $error = $e->getMessage(); //Better database failure response
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
<?php elseif (empty($games)): ?>
    <p>No games played yet.</p>
<?php else: ?>
    <table style="width:100%;border-collapse:collapse;margin-top:1rem;">
        <thead>
            <tr style="background:#175d17;color:#fff;">
                <th style="padding:0.5rem;">Player</th>
                <th style="padding:0.5rem;">Your Hand</th>
                <th style="padding:0.5rem;">Dealer Hand</th>
                <th style="padding:0.5rem;">Result</th>
                <th style="padding:0.5rem;">When</th>
            </tr>
        </thead>
        <tbody>
<?php foreach ($games as $g): ?>
            <tr style="background:#47b27b;color:#fff;">
                <td style="padding:0.5rem;"><?php echo htmlspecialchars($g['player_name']); ?></td>
                <td style="padding:0.5rem;"><?php echo str_replace(',', ' ', $g['player_hand']); ?>
                    (<?php echo $g['player_total']; ?>)</td>
                <td style="padding:0.5rem;"><?php echo str_replace(',', ' ', $g['dealer_hand']); ?>
                    (<?php echo $g['dealer_total']; ?>)</td>
                <td style="padding:0.5rem;font-weight:bold;">
                    <?php echo $g['outcome'] === 'win' ? 'WIN' : ($g['outcome'] === 'lose' ? 'LOSE' : 'TIE'); ?>
                <td style="padding:0.5rem;"><?php echo $g['played_at']; ?></td>
                <td style="padding:0.5rem;">
                    <form method="POST" action="index.php?action=delete_game" style="display:inline;">
                        <input type="hidden" name="game_id" value="<?php echo $g['id']; ?>">
                        <button type="submit" onclick="return confirm('Delete this game?');">Delete</button>
                    </form>    
                </td>
                <td style="padding:0.5rem;"><?php echo $g['played_at']; ?></td>
            </tr>
<?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
    <a href="index.php?action=home" class="btn">Back to Home</a>
</main>
</body>
</html>