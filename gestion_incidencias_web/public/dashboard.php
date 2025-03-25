<?php
require_once '../inc/auth.php';
requireAdminLogin();
require_once '../inc/db.php';

$db = new Database();
$conn = $db->connect();

// KPIs
$totalIncidencias = $conn->query("SELECT COUNT(*) FROM incidencias")->fetchColumn();
$totalPendientes = $conn->query("SELECT COUNT(*) FROM incidencias WHERE estado = 'pendiente'")->fetchColumn();
$totalValidadas = $conn->query("SELECT COUNT(*) FROM incidencias WHERE estado = 'validado'")->fetchColumn();
$totalEnProceso = $conn->query("SELECT COUNT(*) FROM incidencias WHERE estado = 'en proceso'")->fetchColumn();
$totalResueltas = $conn->query("SELECT COUNT(*) FROM incidencias WHERE estado = 'resuelto'")->fetchColumn();
$totalRechazadas = $conn->query("SELECT COUNT(*) FROM incidencias WHERE estado = 'rechazado'")->fetchColumn();
$totalEmpleados = $conn->query("SELECT COUNT(*) FROM empleados")->fetchColumn();
$totalAsignaciones = $conn->query("SELECT COUNT(*) FROM asignaciones")->fetchColumn();

// Incidencias recientes
$stmt = $conn->query("SELECT tipo, descripcion, fecha_reporte, estado FROM incidencias ORDER BY fecha_reporte DESC LIMIT 5");
$ultimasIncidencias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Administrador</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4 class="text-white text-center">ADMIN</h4>
    <a href="dashboard.php" style="background-color:#495057;">📊 Dashboard</a>
    <a href="empleados.php">👷 Empleados</a>
    <a href="incidencias.php">📍 Incidencias</a>
    <a href="reportes.php">📁 Reportes</a>
    <a href="logout.php">🔓 Cerrar sesión</a>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="topbar">
        <h2>Bienvenido, <?php echo $_SESSION['admin_nombre']; ?></h2>
    </div>

    <!-- KPIs -->
    <div class="row">
        <?php
            $cards = [
                'Total Incidencias' => $totalIncidencias,
                'Pendientes' => $totalPendientes,
                'Validadas' => $totalValidadas,
                'En Proceso' => $totalEnProceso,
                'Resueltas' => $totalResueltas,
                'Rechazadas' => $totalRechazadas,
                'Empleados Registrados' => $totalEmpleados,
                'Tareas Asignadas' => $totalAsignaciones
            ];

            foreach ($cards as $title => $value):
        ?>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-primary h-100">
                    <div class="card-body text-center">
                        <h6 class="card-title"><?php echo $title; ?></h6>
                        <h4><?php echo $value; ?></h4>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Gráfico -->
    <div class="row mt-4">
        <div class="col-md-6">
            <h4>Distribución por Estado</h4>
            <canvas id="graficoEstados" height="200"></canvas>
        </div>
    </div>

    <!-- Tabla de últimas incidencias -->
    <div class="mt-5">
        <h4>Últimas Incidencias</h4>
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Tipo</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ultimasIncidencias as $inc): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($inc['tipo']); ?></td>
                        <td><?php echo substr(htmlspecialchars($inc['descripcion']), 0, 50) . '...'; ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($inc['fecha_reporte'])); ?></td>
                        <td><?php echo ucfirst($inc['estado']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Gráfico Script -->
<script>
    const ctx = document.getElementById('graficoEstados').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Pendiente', 'Validado', 'En Proceso', 'Resuelto', 'Rechazado'],
            datasets: [{
                label: 'Cantidad',
                data: [
                    <?= $totalPendientes ?>,
                    <?= $totalValidadas ?>,
                    <?= $totalEnProceso ?>,
                    <?= $totalResueltas ?>,
                    <?= $totalRechazadas ?>
                ],
                backgroundColor: ['orange', 'blue', 'cyan', 'green', 'red']
            }]
        }
    });
</script>

</body>
</html>
