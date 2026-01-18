<?php
declare(strict_types=1);

use Exception\DatabaseException;

class Database
{
    private mysqli $mysqli;
    private mysqli_stmt $query;
    public function connect(string $username, string $password, string $hostname = "127.0.0.1")
    {
        $this->mysqli = new mysqli('localhost', $username, $password, 'my_db', 3306);
        if (!$this->mysqli or $this->mysqli->connect_errno) {
            throw new DatabaseException("Error connecting to the database.");
        }
    }

    public function selectUser(string $email)
    {
        $email = $this->mysqli->escape_string($email);
        $this->query = $this->mysqli->prepare('SELECT * FROM user WHERE email = ?');
        $this->query->bind_param('s', $email);
        return $this;
    }
    public function execute()
    {
        $this->query->execute();
        $result = $this->query->get_result();
        $row = $result->fetch_assoc();
        if ($row === null || !$row) {
            throw new DatabaseException("Error executing query");
        }
        return $row;
    }
    public function insertUser(UserData $userData)
    {
        $email = $this->mysqli->escape_string($userData->email);
        $password = password_hash($userData->password, PASSWORD_BCRYPT);
        $this->query = $this->mysqli->prepare('INSERT INTO user (email, password) VALUES(?, ?)');
        $this->query->bind_param("ss", $email, $password);
        $this->query->execute();
        var_dump($this->mysqli->insert_id);
        return $this;
    }
}