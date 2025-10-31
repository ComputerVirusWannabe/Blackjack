<?php
//Contributions
//Done by David
header('Content-Type: application/json; charset=utf-8'); //UTF-8 JSON response
require_once '../Config.php'; //Database credentials, David's in this version
require_once '../Database.php';//Database wrapper class

try {
    $db = new Database(Config::$db); //connect to database
    $stmt = $db->query("
        SELECT player_name, outcome, player_total, dealer_total, played_at
        FROM game_results
        ORDER BY played_at DESC
        LIMIT 20
    "); //fetch last 20 games
    $data = $stmt->fetchAll(); //get all rows as arrays
    echo json_encode($data, JSON_PRETTY_PRINT); //formatted JSON output
} catch (Exception $e) {
    http_response_code(500); //server error
    echo json_encode(['error' => $e->getMessage()]); //return error in JSON
}
?>