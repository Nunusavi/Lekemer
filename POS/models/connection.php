<?php
session_start();


class Connection
{
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $conn;

    public function __construct()
    {
        if (!isset($_SESSION["company_db"])) {
            die("Access denied: missing company_db session");
        }

        $db_info = $_SESSION["company_db"];
        $this->host = $db_info["host"];
        $this->db_name = $db_info["name"];
        $this->username = $db_info["user"];
        $this->password = $db_info["password"];
    }

    public function connect()
    {
        if ($this->conn === null) {
            try {
                $this->conn = new PDO(
                    "mysql:host=" . trim($this->host) . ";dbname=" . trim($this->db_name),
                    $this->username,
                    $this->password
                );
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $exception) {
                die("DB Connection failed: " . $exception->getMessage());
            }
        }

        return $this->conn;
    }
    public function connection()
    {
        $connObj = new Connection();
        return $connObj->connect();
    }

    public function close()
    {
        $this->conn = null;
    }
}
