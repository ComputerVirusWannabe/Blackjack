<?php
//Contributions
//This part done by David
class Database {
    private $pdo;

    public function __construct(array $config) {
        $dsn = "pgsql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->pdo = new PDO($dsn, $config['user'], $config['password'], $options); //PDO with secure defaults
    }

    public function prepare(string $sql): PDOStatement {
        return $this->pdo->prepare($sql); //wrapper to keep SQL safe
    }

    public function query(string $sql): PDOStatement {
        $stmt = $this->prepare($sql);
        $stmt->execute();
        return $stmt; //for SELECTs
    }
}
?>