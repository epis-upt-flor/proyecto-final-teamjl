<?php
namespace App\Repositories;

use App\Core\Database;
use PDO;

class EmpleadoRepository
{
    public static function obtenerTodos(): array
    {
        $pdo = Database::getInstance();

        $query = "SELECT id, dni, nombre, apellido, email FROM empleado ORDER BY apellido ASC";

        $stmt = $pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
