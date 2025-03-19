<?php
session_start();
require_once '../inc/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = trim($_POST['correo']);
    $password = trim($_POST['password']);
    
    if (empty($correo) || empty($password)) {
        $error = "Por favor, completa todos los campos.";
    } else {
        $db = new Database();
        $conn = $db->connect();
        
        $stmt = $conn->prepare("SELECT id, nombre, password, intentos_fallidos, ultimo_intento FROM administradores WHERE correo = :correo LIMIT 1");
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            $intentos = $admin['intentos_fallidos'];
            $ultimoIntento = strtotime($admin['ultimo_intento']);
            $bloqueoTiempo = 600; // 10 minutos (600 segundos)

            // Verificar si el usuario está bloqueado
            if ($intentos >= 5 && (time() - $ultimoIntento) < $bloqueoTiempo) {
                $error = "Demasiados intentos fallidos. Espere 10 minutos antes de intentarlo de nuevo.";
            } else {
                // Verificar el password
                if (password_verify($password, $admin['password'])) {
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_nombre'] = $admin['nombre'];

                    // Restablecer intentos fallidos en caso de éxito
                    $stmt = $conn->prepare("UPDATE administradores SET intentos_fallidos = 0 WHERE id = :id");
                    $stmt->bindParam(':id', $admin['id'], PDO::PARAM_INT);
                    $stmt->execute();

                    // Redirigir al dashboard
                    header("Location: dashboard.php");
                    exit();
                } else {
                    // Incrementar intentos fallidos y actualizar `ultimo_intento`
                    $stmt = $conn->prepare("UPDATE administradores SET intentos_fallidos = intentos_fallidos + 1, ultimo_intento = NOW() WHERE id = :id");
                    $stmt->bindParam(':id', $admin['id'], PDO::PARAM_INT);
                    $stmt->execute();

                    $error = "Correo o password incorrectos.";
                }
            }
        } else {
            $error = "Correo o password incorrectos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Administrador</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script>
        function validateForm() {
            var correo = document.getElementById('correo').value;
            var password = document.getElementById('password').value;

            if (correo === "" || password === "") {
                alert("Por favor, completa todos los campos.");
                return false;
            }
            var emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
            if (!emailPattern.test(correo)) {
                alert("Por favor, ingresa un correo válido.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2>Login Administrador</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" onsubmit="return validateForm();">
            <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="email" name="correo" id="correo" class="form-control" placeholder="Ingrese su correo" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Ingrese su contraseña" required>
            </div>
            <button type="submit" class="btn btn-primary">Ingresar</button>
        </form>
    </div>
</body>
</html>
