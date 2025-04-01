<?php
require_once("../../inc/protect.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportes Estadísticos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
</head>
<body class="bg-light">
<div class="container py-4">
    <h2 class="mb-4 text-center">Reportes y Estadísticas</h2>

    <div class="row mb-5">
        <div class="col-md-6">
            <h5 class="text-center">📊 Incidencias por Estado</h5>
            <canvas id="graficoEstado"></canvas>
        </div>
        <div class="col-md-6">
            <h5 class="text-center">📌 Incidencias por Tipo</h5>
            <canvas id="graficoTipo"></canvas>
        </div>
    </div>

    <div class="text-center">
        <a href="../dashboard/" class="btn btn-outline-primary">← Volver al Dashboard</a>
        <button class="btn btn-outline-success mx-2" disabled>📄 Descargar PDF (Aún no)</button>
        <button class="btn btn-outline-secondary mx-2" disabled>📊 Exportar Excel (Aún no)</button>
    </div>
</div>

<script>
async function cargarReportes() {
    const res = await fetch("http://localhost:8080/proyecto-final-teamjl/gestion_incidencias_web/api/public/admin_dashboard/resumen_estadistico.php");
    const json = await res.json();

    if (!json.success) {
        alert(json.message);
        return;
    }

    const estados = json.data.por_estado.map(e => e.estado);
    const totalEstados = json.data.por_estado.map(e => e.total);

    new Chart(document.getElementById('graficoEstado'), {
        type: 'doughnut',
        data: {
            labels: estados,
            datasets: [{
                label: 'Cantidad',
                data: totalEstados
            }]
        }
    });

    const tipos = json.data.por_tipo.map(t => t.tipo);
    const totalTipos = json.data.por_tipo.map(t => t.total);

    new Chart(document.getElementById('graficoTipo'), {
        type: 'bar',
        data: {
            labels: tipos,
            datasets: [{
                label: 'Cantidad',
                data: totalTipos
            }]
        }
    });
}

cargarReportes();
</script>
</body>
</html>