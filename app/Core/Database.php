<?php

namespace App\Core;

use PDO;
use PDOException;

class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh;
    private $error;

    public function __construct() {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo "Connection Error: " . $this->error;
        }
    }

    public function query($sql) {
        return $this->dbh->query($sql);
    }

    public function prepare($sql) {
        return $this->dbh->prepare($sql);
    }
    
    public function lastInsertId() {
        return $this->dbh->lastInsertId();
    }
}
