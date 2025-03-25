<?php
class Database {
    // Actualiza con los datos de conexión de NeonTech PostgreSQL
    private $host = "ep-still-unit-a8b5odr0-pooler.eastus2.azure.neon.tech";       // Ejemplo: "neon-host.example.com"
    private $port = "5432";                     // Normalmente es el 5432
    private $dbname = "dbgestionf";      // Nombre de tu base de datos en NeonTech
    private $user = "dbgestionf_owner";           // Usuario proporcionado por NeonTech
    private $password = "npg_7zwC5akVZiox";     // Contraseña asignada
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
