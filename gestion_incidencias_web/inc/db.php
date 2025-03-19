<?php
class Database {
    private $host = "localhost";
    private $port = "5432";
    private $dbname = "dbGestionJL";
    private $user = "postgres";
    private $password = "upt2025";
    private $conn;

    public function connect() {
        try {
            $this->conn = new PDO("pgsql:host={$this->host};port={$this->port};dbname={$this->dbname}", $this->user, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
?>
