<?php

//Contributions
//Done by Vien, David added contributions header comment

date_default_timezone_set('America/New_York');

function generateDeck() {
    $suits = ['A','2','3','4','5','6','7','8','9','10','J','Q','K'];
    $colors = ['S','H','D','C'];
    $deck = [];
    foreach ($suits as $suit) {
        foreach ($colors as $color) {
            $deck[] = $suit.$color;
        }
    }
    shuffle($deck); 
    return $deck;
}

function drawCard(&$deck) {
    return array_pop($deck);
}

function calculateTotal($hand) {
    $total = 0;
    $aces = 0;
    foreach ($hand as $card) {
        $value = substr($card, 0, -1);
        if (is_numeric($value)) $total += intval($value);
        elseif ($value === 'A') { $total += 11; $aces++; }
        else $total += 10;
    }
    # Adjust for aces
    while ($total > 21 && $aces > 0) {
        $total -= 10;
        $aces--;
    }
    return $total;
}

function checkWinner($playerHand, $dealerHand) {
    $playerTotal = calculateTotal($playerHand);
    $dealerTotal = calculateTotal($dealerHand);

    if ($playerTotal > 21) return 'lose';
    if ($dealerTotal > 21) return 'win';
    if ($playerTotal > $dealerTotal) return 'win';
    if ($playerTotal < $dealerTotal) return 'lose';
    return 'tie';
}
