<?php
require_once("../../inc/protect.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Gestión de Incidencias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
</head>
<body class="bg-light">

<div class="container py-5">
    <h2 class="mb-4 text-center">Panel de Control del Administrador</h2>

    <div class="row text-center mb-4">
        <div class="col-md-4">
            <div class="card border-danger">
                <div class="card-body">
                    <h5 class="card-title text-danger">Pendientes</h5>
                    <h2 id="pendientes" class="fw-bold">0</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-warning">
                <div class="card-body">
                    <h5 class="card-title text-warning">En Desarrollo</h5>
                    <h2 id="en_desarrollo" class="fw-bold">0</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success">
                <div class="card-body">
                    <h5 class="card-title text-success">Terminadas</h5>
                    <h2 id="terminadas" class="fw-bold">0</h2>
                </div>
            </div>
        </div>
    </div>

    <canvas id="grafico" height="100"></canvas>

    <hr class="my-5">

    <div class="text-center">
        <a href="../incidencias/" class="btn btn-outline-primary m-2">Ver Incidencias</a>
        <a href="../empleados/" class="btn btn-outline-secondary m-2">Ver Empleados</a>
        <a href="../reporte/" class="btn btn-outline-success m-2">Ver Reportes</a>
        <a href="../login_register/logout.php" class="btn btn-outline-danger m-2">Cerrar Sesión</a>
    </div>
</div>

<script>
    async function cargarDashboard() {
        const res = await fetch("http://localhost:8080/proyecto-final-teamjl/gestion_incidencias_web/api/public/admin_dashboard/resumen_incidencias.php");
        const json = await res.json();

        if (json.success) {
            const datos = json.data;

            document.getElementById('pendientes').textContent = datos['Pendiente'];
            document.getElementById('en_desarrollo').textContent = datos['En Desarrollo'];
            document.getElementById('terminadas').textContent = datos['Terminado'];

            const ctx = document.getElementById('grafico').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Pendiente', 'En Desarrollo', 'Terminado'],
                    datasets: [{
                        label: 'Cantidad de Incidencias',
                        data: [datos['Pendiente'], datos['En Desarrollo'], datos['Terminado']],
                        backgroundColor: ['#dc3545', '#ffc107', '#28a745']
                    }]
                }
            });
        }
    }

    cargarDashboard();
</script>

</body>
</html>