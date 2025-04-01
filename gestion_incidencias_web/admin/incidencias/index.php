<?php
require_once("../../inc/protect.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Incidencias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h2 class="mb-4 text-center">Todas las Incidencias Reportadas</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-hover bg-white">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Descripción</th>
                    <th>Ubicación</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody id="tabla-incidencias">
                <tr><td colspan="7" class="text-center">Cargando...</td></tr>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <a href="../dashboard/" class="btn btn-outline-primary">← Volver al Dashboard</a>
    </div>
</div>

<script>
    async function cargarIncidencias() {
        try {
            const res = await fetch("http://localhost:8080/proyecto-final-teamjl/gestion_incidencias_web/api/public/admin_dashboard/incidencias.php");
            const json = await res.json();

            const cuerpo = document.getElementById("tabla-incidencias");
            cuerpo.innerHTML = "";

            if (!json.success) {
                cuerpo.innerHTML = `<tr><td colspan="7" class="text-danger text-center">${json.message}</td></tr>`;
                return;
            }

            json.data.forEach(inc => {
                const fila = `
                    <tr>
                        <td>${inc.id}</td>
                        <td>${inc.tipo}</td>
                        <td>${inc.estado}</td>
                        <td>${inc.descripcion}</td>
                        <td>${inc.latitud}, ${inc.longitud}</td>
                        <td>${inc.fecha_reporte}</td>
                    </tr>
                `;
                cuerpo.innerHTML += fila;
            });
        } catch (error) {
            document.getElementById("tabla-incidencias").innerHTML = `<tr><td colspan="7" class="text-danger text-center">Error de conexión al servidor</td></tr>`;
        }
    }

    cargarIncidencias();
</script>
</body>
</html>