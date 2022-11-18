<?php

include 'Database.php';

class Account {
    private Database $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getUserID($username) {
        $sql = "SELECT id FROM news.user WHERE username = ? LIMIT 1";
        $stmt = $this->db->getConn()->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['id'];
    }

    public function register($username, $password, $email) {
        $sql = "INSERT INTO news.user (`username`, `password`, `email`) VALUES (?, ?, ?)";
        $stmt = $this->db->getConn()->prepare($sql);
        $stmt->bind_param("sss", $username, $password, $email);
        $stmt->execute();
        return $stmt;
    }

    public function login($username, $password) {
        $sql = "SELECT id, username, `password` FROM news.user WHERE username = ? LIMIT 1";
        $stmt = $this->db->getConn()->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $login = $result->fetch_assoc();
            if (password_verify($password, $login['password'])) {
                return $login;
            }
        }
        return null;
    }

    public function isAdmin($user_id): ?bool {
        $sql = "SELECT * FROM news.admin WHERE user_id = ? LIMIT 1";
        $stmt = $this->db->getConn()->prepare($sql);
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function isAuthor($username): ?bool {
        $user_id = $this->getUserID($username);
        $sql = "SELECT * FROM news.author WHERE user_id = ? LIMIT 1";
        $stmt = $this->db->getConn()->prepare($sql);
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function userExists($username): ?bool {
        $sql = "SELECT * FROM news.user WHERE username = ? LIMIT 1";
        $stmt = $this->db->getConn()->prepare($sql);
        $stmt->bind_param("s", $username);
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

    public function hasFullAccess($username):bool {
        $user_id = $this->getUserID($username);
        $sql = "SELECT full_access FROM news.admin WHERE user_id = ? LIMIT 1";
        $stmt = $this->db->getConn()->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['full_access'] == 1;
    }

    public function getAuthorsList($start = 0):array {
        $sql = "SELECT CONCAT(first_name, ' ', last_name) as name, date_since, active FROM news.author LIMIT ?, 10";
        $sql2 = "SELECT COUNT(*) AS count FROM news.author";
        $stmt = $this->db->getConn()->prepare($sql);
        $stmt2 = $this->db->getConn()->prepare($sql2);
        $stmt->bind_param("i", $start);
        $stmt->execute();

        $list = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt2->execute();
        $count = $stmt2->get_result()->fetch_assoc()['count'];

        return array('count' => $count, 'authors' => $list);
    }

    public function addAuthor($username, $fname, $lname) {
        $user_id = $this->getUserID($username);
        $sql = "INSERT INTO news.author (user_id, first_name, last_name) VALUES (?, ?, ?)";
        $stmt = $this->db->getConn()->prepare($sql);
        $stmt->bind_param("iss", $user_id, $fname, $lname);
        $stmt->execute();
        return $stmt;
    }

    public function changeEmail($username, $newEmail) {
        $sql = "UPDATE news.user SET email = ? WHERE username = ?";
        $stmt = $this->db->getConn()->prepare($sql);
        $stmt->bind_param("ss", $newEmail, $username);
        $stmt->execute();
        return $stmt;
    }

    public function changePassword($username, $currentPassword, $newPassword) {
        $sql = "SELECT `password` FROM news.user WHERE username = ? LIMIT 1";
        $stmt = $this->db->getConn()->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (password_verify($currentPassword, $result['passwd'])) {
            $sql = "UPDATE news.user SET `password` = ? WHERE username = ?";
            $stmt = $this->db->getConn()->prepare($sql);
            $stmt->bind_param("ss", $newPassword, $username);
            $stmt->execute();
            return $stmt;
        }
        return false;
    }
}
