<?php
require_once("../../inc/auth.php");
require_once("../../inc/db.php");
require_once("../../inc/config.php");
require_once("../../inc/header.php");

if (!isset($_GET['id'])) {
    echo "<p>ID de incidencia no especificado.</p>";
    require_once("../../inc/footer.php");
    exit();
}

$id = $_GET['id'];

$stmt = $pdo->prepare("
    SELECT i.*, ti.nombre AS tipo, ei.nombre AS estado
    FROM incidencia i
    JOIN tipo_incidencia ti ON i.tipo_id = ti.id
    JOIN estado_incidencia ei ON i.estado_id = ei.id
    WHERE i.id = :id
");
$stmt->execute(['id' => $id]);
$incidencia = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$incidencia) {
    echo "<p>Incidencia no encontrada.</p>";
    require_once("../../inc/footer.php");
    exit();
}
?>

<h2>📌 Detalle de la Incidencia #<?php echo $id; ?></h2>
<a href="index.php">← Volver al listado</a>

<table>
    <tr><th>Tipo</th><td><?php echo htmlspecialchars($incidencia['tipo']); ?></td></tr>
    <tr><th>Estado actual</th><td><?php echo $incidencia['estado']; ?></td></tr>
    <tr><th>Fecha de reporte</th><td><?php echo $incidencia['fecha_reporte']; ?></td></tr>
    <tr><th>Descripción</th><td><?php echo nl2br(htmlspecialchars($incidencia['descripcion'])); ?></td></tr>
    <tr>
        <th>Ubicación</th>
        <td>
            Lat: <?php echo $incidencia['latitud']; ?> <br>
            Lon: <?php echo $incidencia['longitud']; ?> <br>
            <a href="https://www.google.com/maps?q=<?php echo $incidencia['latitud'] . ',' . $incidencia['longitud']; ?>" target="_blank">Ver en Google Maps</a>
        </td>
    </tr>
    <tr>
        <th>Foto</th>
        <td>
            <?php if ($incidencia['foto']): ?>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($incidencia['foto']); ?>" width="300">
            <?php else: ?>
                No se adjuntó imagen.
            <?php endif; ?>
        </td>
    </tr>
</table>

<?php require_once("../../inc/footer.php"); ?>
