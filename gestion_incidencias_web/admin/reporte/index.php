<?php
require_once("../../inc/auth.php");
require_once("../../inc/db.php");

$fecha_inicio = $_GET['inicio'] ?? date('Y-m-01');
$fecha_fin = $_GET['fin'] ?? date('Y-m-d');

// Consulta resumen por estado
$resumen = $pdo->prepare("
    SELECT ei.nombre AS estado, COUNT(*) AS total
    FROM incidencia i
    JOIN estado_incidencia ei ON i.estado_id = ei.id
    WHERE i.fecha_reporte BETWEEN :inicio AND :fin
    GROUP BY ei.nombre
");
$resumen->execute(['inicio' => $fecha_inicio, 'fin' => $fecha_fin]);
$datos_estado = $resumen->fetchAll(PDO::FETCH_ASSOC);

// Consulta resumen por tipo
$tipos = $pdo->prepare("
    SELECT ti.nombre AS tipo, COUNT(*) AS total
    FROM incidencia i
    JOIN tipo_incidencia ti ON i.tipo_id = ti.id
    WHERE i.fecha_reporte BETWEEN :inicio AND :fin
    GROUP BY ti.nombre
");
$tipos->execute(['inicio' => $fecha_inicio, 'fin' => $fecha_fin]);
$datos_tipo = $tipos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte General</title>
</head>
<body>
    <h2>Reporte General de Incidencias</h2>
    <a href="../dashboard/index.php">← Volver al Dashboard</a><br><br>

    <form method="GET">
        <label>Desde:</label>
        <input type="date" name="inicio" value="<?php echo $fecha_inicio; ?>" required>
        <label>Hasta:</label>
        <input type="date" name="fin" value="<?php echo $fecha_fin; ?>" required>
        <button type="submit">Filtrar</button>
    </form>

    <h3>Resumen por Estado</h3>
    <ul>
        <?php foreach ($datos_estado as $row): ?>
            <li><?php echo $row['estado']; ?>: <strong><?php echo $row['total']; ?></strong></li>
        <?php endforeach; ?>
    </ul>

    <h3>Resumen por Tipo de Incidencia</h3>
    <ul>
        <?php foreach ($datos_tipo as $row): ?>
            <li><?php echo $row['tipo']; ?>: <strong><?php echo $row['total']; ?></strong></li>
        <?php endforeach; ?>
    </ul>

    <hr>
    <h3>Exportar Reporte</h3>
    <a href="generar_pdf.php?inicio=<?php echo $fecha_inicio; ?>&fin=<?php echo $fecha_fin; ?>" target="_blank">📄 Generar PDF</a><br>
    <a href="generar_excel.php?inicio=<?php echo $fecha_inicio; ?>&fin=<?php echo $fecha_fin; ?>">📊 Generar Excel</a>
</body>
</html>