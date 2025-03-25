<?php
require_once '../inc/auth.php';
requireAdminLogin();
require_once '../inc/db.php';

$db = new Database();
$conn = $db->connect();

// Obtener todas las incidencias
$stmt = $conn->query("SELECT i.id, u.nombre AS ciudadano, i.tipo, i.descripcion, i.direccion, i.fecha_reporte, i.estado
                      FROM incidencias i
                      JOIN usuarios u ON i.id_usuario = u.id
                      ORDER BY i.fecha_reporte DESC");
$incidencias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Incidencias</title>
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
            color: #fff;
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
    <a href="empleados.php">👷 Empleados</a>
    <a href="incidencias.php" style="background-color:#495057;">📍 Incidencias</a>
    <a href="reportes.php">📁 Reportes</a>
    <a href="logout.php">🔓 Cerrar sesión</a>
</div>

<!-- Main -->
<div class="main-content">
    <h2>Gestión de Incidencias</h2>

    <table class="table table-bordered table-hover mt-4">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Ciudadano</th>
                <th>Tipo</th>
                <th>Descripción</th>
                <th>Dirección</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($incidencias as $inc): ?>
                <tr>
                    <form method="POST" action="incidencias_update.php">
                        <td><?php echo $inc['id']; ?></td>
                        <td><?php echo htmlspecialchars($inc['ciudadano']); ?></td>
                        <td><?php echo htmlspecialchars($inc['tipo']); ?></td>
                        <td><?php echo substr(htmlspecialchars($inc['descripcion']), 0, 30) . '...'; ?></td>
                        <td><?php echo htmlspecialchars($inc['direccion']); ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($inc['fecha_reporte'])); ?></td>
                        <td>
                            <input type="hidden" name="id_incidencia" value="<?php echo $inc['id']; ?>">
                            <select name="nuevo_estado" class="form-control">
                                <?php
                                    $estados = ['pendiente', 'validado', 'en proceso', 'resuelto', 'rechazado'];
                                    foreach ($estados as $estado):
                                        $selected = $estado === $inc['estado'] ? 'selected' : '';
                                        echo "<option value='$estado' $selected>" . ucfirst($estado) . "</option>";
                                    endforeach;
                                ?>
                            </select>
                        </td>
                        <td><button type="submit" class="btn btn-primary btn-sm">Actualizar</button></td>
                    </form>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>