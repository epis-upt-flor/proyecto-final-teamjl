<?php
    require_once '../inc/db.php';

    $error = '';
    $success = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nombre = trim($_POST['nombre']);
        $correo = trim($_POST['correo']);
        $password = trim($_POST['password']);
        $rol = 'admin';

        if (empty($nombre) || empty($correo) || empty($password)) {
            $error = "Todos los campos son obligatorios.";
        }elseif (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,}$/", $nombre)) {
            $error = "El nombre debe tener al menos 3 letras y solo contener caracteres alfabéticos.";
        }elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $error = "El correo no es válido.";
        }elseif (!preg_match("/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/", $password)) {
            $error = "La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial.";
        }else {
            $db = new Database();
            $conn = $db->connect();

            $stmt = $conn->prepare("SELECT id FROM administradores WHERE correo = :correo");
            $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->fetch()) {
                $error = "El correo ya está registrado.";
            } else {
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                $stmt = $conn->prepare("INSERT INTO administradores (nombre, correo, password, rol) VALUES (:nombre, :correo, :password, :rol)");
                $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
                $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
                $stmt->bindParam(':rol', $rol, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    $success = "Administrador registrado con éxito. Ahora puede iniciar sesión.";
                } else {
                    $error = "Ocurrió un error al registrar. Intente nuevamente.";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro Administrador</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Registro de Administrador</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="email" name="correo" id="correo" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password" class="form-control" required>
                <small class="text-muted">Debe contener al menos 8 caracteres, una mayúscula, un número y un carácter especial.</small>
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
        <a href="login.php">Ya tienes cuenta? Inicia sesión</a>
    </div>
</body>
</html>