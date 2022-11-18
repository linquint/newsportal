<?php

include 'Database.php';

class Account {
    private Database $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function register($username, $password, $email) {
        $sql = "INSERT INTO news.user (username, passwd, email) VALUES (?, ?, ?)";
        $stmt = $this->db->getConn()->prepare($sql);
        $stmt->bind_param("sss", $username, $password, $email);
        $stmt->execute();
        return $stmt;
    }

    public function login($username, $password) {
        $sql = "SELECT * FROM news.user WHERE username = ? AND passwd = ?";
        $stmt = $this->db->getConn()->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $response = $stmt->get_result();
        return ($response->num_rows > 0) ? $response->fetch_assoc() : null;
    }

    public function isAdmin($user_id): ?bool {
        $sql = "SELECT * FROM news.admin WHERE user_id = ? LIMIT 1";
        $stmt = $this->db->getConn()->prepare($sql);
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function isAuthor($user_id): ?bool {
        $sql = "SELECT * FROM news.author WHERE user_id = ? LIMIT 1";
        $stmt = $this->db->getConn()->prepare($sql);
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function isAvailable($username = "", $email = ""):bool {
        $sql = "SELECT * FROM news.user WHERE username = ? OR email = ? LIMIT 1";
        $stmt = $this->db->getConn()->prepare($sql);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        return $stmt->get_result()->num_rows == 0;
    }
}
