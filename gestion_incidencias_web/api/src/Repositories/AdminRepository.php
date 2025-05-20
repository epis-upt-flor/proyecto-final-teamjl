<?php

    namespace App\Repositories;

    use App\Core\Database;
    use PDO;

    class AdminRepository
    {
        public static function obtenerPorEmail(string $email): ?array
        {
            $pdo = Database::getInstance();
            $stmt = $pdo->prepare("SELECT * FROM administrador WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            return $admin ?: null;
        }

        public static function registrar(array $data): bool
        {
            $pdo = Database::getInstance();
            $stmt = $pdo->prepare("
                    INSERT INTO administrador (nombre, apellido, email, password)
                    VALUES (:nombre, :apellido, :email, :password)
                ");

            return $stmt->execute([
                'nombre' => $data['nombre'],
                'apellido' => $data['apellido'],
                'email' => $data['email'],
                'password' => $data['password']
            ]);
        }
    }

?>