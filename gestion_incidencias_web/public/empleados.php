<?php
require_once '../inc/auth.php';
requireAdminLogin();
require_once '../inc/db.php';

$db = new Database();
$conn = $db->connect();

// Obtener empleados con su información de usuario
$stmt = $conn->query("
    SELECT u.id, u.nombre, u.correo, e.dni, e.telefono, e.especialidad, e.estado, e.fecha_registro
    FROM usuarios u
    JOIN empleados e ON u.id = e.id_usuario
    ORDER BY u.nombre ASC
");
$empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Empleados</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body { display: flex; }
        .sidebar {
            width: 220px;
            height: 100vh;
            position: fixed;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar a {
            color: #ffffff;
            padding: 15px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover { background-color: #495057; }
        .main-content {
            margin-left: 220px;
            padding: 30px;
            width: 100%;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4 class="text-white text-center">ADMIN</h4>
    <a href="dashboard.php">📊 Dashboard</a>
    <a href="empleados.php" style="background-color:#495057;">👷 Empleados</a>
    <a href="incidencias.php">📍 Incidencias</a>
    <a href="reportes.php">📁 Reportes</a>
    <a href="logout.php">🔓 Cerrar sesión</a>
</div>

<!-- Contenido principal -->
<div class="main-content">
    <h2>Gestión de Empleados</h2>

    <table class="table table-bordered table-hover mt-4">
        <thead class="thead-dark">
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>DNI</th>
                <th>Teléfono</th>
                <th>Especialidad</th>
                <th>Estado</th>
                <th>Registrado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($empleados as $emp): ?>
                <tr>
                    <form method="POST" action="empleados_update.php">
                        <td><?php echo htmlspecialchars($emp['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($emp['correo']); ?></td>
                        <td><?php echo htmlspecialchars($emp['dni']); ?></td>
                        <td><?php echo htmlspecialchars($emp['telefono']); ?></td>
                        <td><?php echo htmlspecialchars($emp['especialidad']); ?></td>
                        <td>
                            <input type="hidden" name="id_usuario" value="<?php echo $emp['id']; ?>">
                            <select name="nuevo_estado" class="form-control">
                                <option value="activo" <?= $emp['estado'] === 'activo' ? 'selected' : '' ?>>Activo</option>
                                <option value="inactivo" <?= $emp['estado'] === 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
                            </select>
                        </td>
                        <td><?php echo date('d/m/Y', strtotime($emp['fecha_registro'])); ?></td>
                        <td><button type="submit" class="btn btn-sm btn-primary">Actualizar</button></td>
                    </form>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>