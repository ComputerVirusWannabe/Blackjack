<?php

//Link: https://cs4640.cs.virginia.edu/xqe2db/Sprint3/Blackjack-main/index.php //final version currently only hosted on David's Database

//Contributions (this file)
//Initially done by Vien, David added 'history' to routing and added contributions header

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include_once('functions.php'); // helper functions: generateDeck, drawCard, calculateTotal, checkWinner

// Default
$action = $_GET['action'] ?? 'home';
$error = '';

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Player name submission
    if (isset($_POST['username'])) {
        $playerName = trim($_POST['username']);
        if (!preg_match("/^[A-Za-z0-9_]{1,20}$/", $playerName)) {
            $error = "Invalid name: only letters, numbers, underscores allowed, max 20 chars.";
            $action = 'home';
        } else {
            $_SESSION['playerName'] = htmlspecialchars($playerName);

            // Initialize new game when starting
            $_SESSION['deck'] = generateDeck();
            $_SESSION['playerHand'] = [drawCard($_SESSION['deck']), drawCard($_SESSION['deck'])];
            $_SESSION['dealerHand'] = [drawCard($_SESSION['deck']), drawCard($_SESSION['deck'])];

            $action = 'game';
        }
    }

    // Hit, Stand actions
    if (isset($_POST['action']) && isset($_SESSION['deck'])) {
        $playerAction = $_POST['action'];

        if ($playerAction === 'hit') {
            $_SESSION['playerHand'][] = drawCard($_SESSION['deck']);
            if (calculateTotal($_SESSION['playerHand']) > 21) {
                $action = 'result';
            } else {
                $action = 'game';
            }
        } elseif ($playerAction === 'stand') {
            // Dealer draws until 16+
            while (calculateTotal($_SESSION['dealerHand']) < 16) {
                $_SESSION['dealerHand'][] = drawCard($_SESSION['deck']);
            }
            $action = 'result';
        }
    }
}

// Routing 
switch ($action) {
    case 'game':
        include 'game.php';
        break;
    case 'result':
        include 'result.php';
        break;
    case 'history':
        include 'History.php';
        break;    
    case 'rules':
        include 'rules.php';
        break;
    case 'delete_game': //For deleting games, connects with History.php section
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['game_id'])) {
            require_once 'Config.php';
            require_once 'Database.php';
            $db = new Database(Config::$db);
            $stmt = $db->prepare("DELETE FROM game_results WHERE id = ?");
            $stmt->execute([$_POST['game_id']]);
        }
        header('Location: index.php?action=history');
        exit;    
    case 'home':
    default:
        include 'home.php';
        break;
}
?>
