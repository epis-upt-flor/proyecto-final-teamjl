<?php
    class AuthController
    {
        public function login()
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $email    = trim($_POST['email'] ?? '');
                $password = trim($_POST['password'] ?? '');

                $ch = curl_init(API_BASE . 'login.php');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(compact('email','password')));
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                $response = curl_exec($ch);
                curl_close($ch);

                $data = json_decode($response, true);
                if (!empty($data['success'])) {
                    $_SESSION['user_id']    = $data['data']['id'];
                    $_SESSION['admin_nombre'] = $data['data']['nombre'].' '.$data['data']['apellido'];
                    $_SESSION['user_role']  = $data['data']['role'];
                    $_SESSION['user_token']    = $data['data']['token'];
                    if ($data['data']['role']==='administrador') {
                        header('Location: ' . url('dashboard'));
                    } else {
                        header('Location: ' . url('incidencias'));
                    }
                    exit;
                }
                $error = $data['message'] ?? 'Credenciales inválidas.';
                authView('login', compact('error'));
            } else {
                authView('login');
            }
        }

        public function register()
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nombre   = trim($_POST['nombre']   ?? '');
                $apellido = trim($_POST['apellido'] ?? '');
                $email    = trim($_POST['email']    ?? '');
                $password = trim($_POST['password'] ?? '');
                $role     = $_POST['role'] ?? 'administrador';

                $ch = curl_init(API_BASE . 'register.php');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(compact(
                    'nombre','apellido','email','password','role'
                )));
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json'
                ]);
                $response = curl_exec($ch);
                curl_close($ch);

                $data = json_decode($response, true);

                if (!empty($data['success'])) {
                    header('Location: ' . url('auth/login'));
                    exit;
                }

                $error = $data['message'] ?? 'Error en el registro.';
                authView('register', compact('error'));
            } else {
                authView('register');
            }
        }

        public function logout()
        {
            $_SESSION = [];
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(
                    session_name(),
                    '',
                    time() - 42000,
                    $params["path"],
                    $params["domain"],
                    $params["secure"],
                    $params["httponly"]
                );
            }
            session_destroy();
            header('Location: ' . url('auth/login'));
            exit;
        }
    }
?>