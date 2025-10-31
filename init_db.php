<?php

//Contributions
//This part done by David

error_reporting(E_ALL);
ini_set('display_errors', 1); //Show setup errors, used in debugging

require_once 'Config.php'; //Database credentials
require_once 'Database.php'; //DB wrapper class

echo "<pre>Starting database initialization...\n";

try {
    $db = new Database(Config::$db); //connect to PostgreSQL
    echo "Connected to database successfully.\n";

    $db->prepare("DROP TABLE IF EXISTS game_results")->execute(); //remove old table
    echo "Dropped game_results (if existed)\n";

    $db->prepare("
        CREATE TABLE game_results (
            id            SERIAL PRIMARY KEY,
            player_name   VARCHAR(50) NOT NULL,
            player_hand   TEXT        NOT NULL,   -- CSV of cards
            dealer_hand   TEXT        NOT NULL,
            player_total  INTEGER     NOT NULL,
            dealer_total  INTEGER     NOT NULL,
            outcome       VARCHAR(10) NOT NULL,   -- win / lose / tie
            played_at     TIMESTAMP   DEFAULT CURRENT_TIMESTAMP
        )
    ")->execute();
    echo "Created game_results\n";
    echo "\nDatabase ready – you can now play!\n";
} catch (PDOException $e) {
    echo "\nPDO ERROR: " . $e->getMessage() . "\nLine: " . $e->getLine() . "\n"; //More detailed error
} catch (Exception $e) {
    echo "\nGENERAL ERROR: " . $e->getMessage() . "\n"; //catch other issues
}
?>