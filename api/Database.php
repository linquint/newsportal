<?php

class Database {
    private string $host = "localhost";
    private string $db_name = "news";
    private string $username = "siui";
    private string $password = "asdasd";
    public $conn;

    public function __construct() {
        try {
            $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
        } catch(Exception $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
    }

    public function getConn() {
        return $this->conn;
    }

    public function __destruct() {
        $this->conn->close();
    }
}