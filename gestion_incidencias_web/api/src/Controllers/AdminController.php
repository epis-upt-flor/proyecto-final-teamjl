<?php
    #Llamamos al namespace y las dependencias
    namespace App\Controllers;

    use App\Services\AdminService;
    use App\Core\Database;
    use App\Core\Auth;
    use App\Core\Response;
    use PDO;
    use Exception;

    #Declaramos la clase con el método estático para el login
    class AdminController {
        public static function login(array $data): void
        {
            if (empty($data['email']) || empty($data['password'])) {
                Response::error("Email y contraseña son requeridos", 422);
            }
        
            $admin = AdminService::login($data['email'], $data['password']);
        
            if (!$admin) {
                Response::error("Credenciales incorrectas", 401);
            }
        
            session_start();
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_nombre'] = $admin['nombre'];
        
            Response::success(['admin' => $admin], "Inicio de sesión exitoso");
        }

        public static function register(array $data): void
        {
            if (
                empty($data['nombre']) ||
                empty($data['apellido']) ||
                empty($data['email']) ||
                empty($data['password'])
            ) {
                Response::error("Todos los campos son obligatorios", 422);
            }
        
            $existente = AdminService::login($data['email'], $data['password']);
            if ($existente) {
                Response::error("Ya existe un administrador con ese email", 409);
            }
        
            $exito = AdminService::registrar($data);
        
            if ($exito) {
                Response::success([], "Administrador registrado correctamente");
            } else {
                Response::error("Error al registrar el administrador", 500);
            }
        }
    }
?>