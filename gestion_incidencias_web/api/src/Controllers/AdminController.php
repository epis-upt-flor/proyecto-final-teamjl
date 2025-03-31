<?php
    #Llamamos al namespace y las dependencias
    namespace App\Controllers;
    use App\Core\Database;
    use App\Core\Auth;
    use App\Core\Response;
    use PDO;
    use Exception;

    #Declaramos la clase con el método estático para el login
    class AdminController {
        public static function login(string $email, string $password): void
        {
            #Usamos try y catch para para agrupar las operaciones y, si hay algún error,
            #se envía la respuesta con el código HTTP 500
            try {
                $pdo = Database::getInstance();

                $stmt = $pdo->prepare("SELECT * FROM administrador WHERE email = :email");
                $stmt->execute(['email' => $email]);
                $admin = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$admin || !password_verify($password, $admin['password'])) {
                    Response::error("Credenciales inválidas", 401);
                }

                // Generar token JWT con info básica
                $token = Auth::generarToken([
                    'admin_id' => $admin['id'],
                    'nombre' => $admin['nombre']
                ]);

                Response::success([
                    'token' => $token,
                    'admin_id' => $admin['id'],
                    'nombre' => $admin['nombre']
                ], "Inicio de sesión exitoso");
            } catch (Exception $e) {
                Response::error("Error interno: " . $e->getMessage(), 500);
            }
        }

        public static function register(array $data): void
        {
            if (
                empty($data['nombre']) ||
                empty($data['apellido']) ||
                empty($data['email']) ||
                empty($data['password'])
            ) {
                Response::error("Nombre, apellido, correo y contraseña son obligatorios", 422);
            }
        
            $nombre = trim($data['nombre']);
            $apellido = trim($data['apellido']);
            $email = trim($data['email']);
            $password = trim($data['password']);
        
            try {
                $pdo = Database::getInstance();
        
                // Verificar si ya existe
                $stmt = $pdo->prepare("SELECT id FROM administrador WHERE email = :email");
                $stmt->execute(['email' => $email]);
        
                if ($stmt->fetch()) {
                    Response::error("Ya existe un administrador con ese correo", 409);
                }
        
                // Hashear
                $hashed = password_hash($password, PASSWORD_DEFAULT);
        
                // Insertar
                $stmt = $pdo->prepare("
                    INSERT INTO administrador (nombre, apellido, email, password)
                    VALUES (:nombre, :apellido, :email, :password)
                ");
                $stmt->execute([
                    'nombre' => $nombre,
                    'apellido' => $apellido,
                    'email' => $email,
                    'password' => $hashed
                ]);
        
                Response::success([], "Administrador registrado correctamente");
            } catch (\Exception $e) {
                Response::error("Error interno: " . $e->getMessage(), 500);
            }
        }
    }
?>