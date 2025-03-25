<?php
require_once '../inc/auth.php';
requireAdminLogin();
require_once '../inc/db.php';

$db = new Database();
$conn = $db->connect();

$incidencias = $conn->query("
    SELECT i.id, i.tipo, i.direccion
    FROM incidencias i
    WHERE i.estado IN ('pendiente', 'validado')
    AND NOT EXISTS (
        SELECT 1 FROM asignaciones a WHERE a.id_incidencia = i.id
    )
    ORDER BY i.fecha_reporte DESC
")->fetchAll(PDO::FETCH_ASSOC);

$empleados = $conn->query("
    SELECT u.id, u.nombre 
    FROM usuarios u
    JOIN empleados e ON u.id = e.id_usuario
    WHERE e.estado = 'activo'
    ORDER BY u.nombre
")->fetchAll(PDO::FETCH_ASSOC);

$idAdmin = $_SESSION['admin_id'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Incidencia</title>
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

<div class="sidebar">
    <h4 class="text-white text-center">ADMIN</h4>
    <a href="dashboard.php">📊 Dashboard</a>
    <a href="empleados.php">👷 Empleados</a>
    <a href="incidencias.php">📍 Incidencias</a>
    <a href="asignar_incidencia.php" style="background-color:#495057;">✅ Asignar Incidencia</a>
    <a href="reportes.php">📁 Reportes</a>
    <a href="logout.php">🔓 Cerrar sesión</a>
</div>

<div class="main-content">
    <h2>Asignar Incidencia a Empleado</h2>

    <form action="../api/asignar_tarea.php" method="POST" class="mt-4">

        <div class="form-group">
            <label for="id_incidencia">Seleccionar Incidencia:</label>
            <select name="id_incidencia" id="id_incidencia" class="form-control" required>
                <option value="">-- Seleccione una incidencia --</option>
                <?php foreach ($incidencias as $inc): ?>
                    <option value="<?= $inc['id'] ?>">
                        [#<?= $inc['id'] ?>] <?= htmlspecialchars($inc['tipo']) ?> - <?= htmlspecialchars($inc['direccion']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="id_empleado">Asignar a:</label>
            <select name="id_empleado" id="id_empleado" class="form-control" required>
                <option value="">-- Seleccione un empleado --</option>
                <?php foreach ($empleados as $emp): ?>
                    <option value="<?= $emp['id'] ?>"><?= htmlspecialchars($emp['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="prioridad">Prioridad:</label>
            <select name="prioridad" class="form-control">
                <option value="media" selected>Media</option>
                <option value="alta">Alta</option>
                <option value="baja">Baja</option>
            </select>
        </div>

        <div class="form-group">
            <label for="comentarios">Comentarios:</label>
            <textarea name="comentarios" class="form-control" rows="3" placeholder="Detalles o instrucciones adicionales (opcional)"></textarea>
        </div>

        <input type="hidden" name="id_administrador" value="<?= $idAdmin ?>">

        <button type="submit" class="btn btn-success">Asignar Tarea</button>
    </form>
</div>

</body>
</html>
