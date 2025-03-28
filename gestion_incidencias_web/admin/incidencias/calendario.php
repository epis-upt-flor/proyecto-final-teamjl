<?php
require_once("../../inc/auth.php");
require_once("../../inc/db.php");
require_once("../../inc/config.php");
require_once("../../inc/header.php");

$stmt = $pdo->query("
    SELECT c.id, c.fecha_programada, c.observaciones,
           i.id AS incidencia_id, ti.nombre AS tipo, e.nombre AS estado
    FROM calendario_incidencia c
    JOIN incidencia i ON c.incidencia_id = i.id
    JOIN tipo_incidencia ti ON i.tipo_id = ti.id
    JOIN estado_incidencia e ON i.estado_id = e.id
    ORDER BY c.fecha_programada ASC
");
$calendario = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>🗓️ Calendario de Intervenciones</h2>
<p>Consulta las incidencias que tienen fechas programadas para su atención.</p>

<?php if (!empty($calendario)): ?>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>ID Incidencia</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th>Observaciones</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($calendario as $item): ?>
                <tr>
                    <td><?php echo $item['fecha_programada']; ?></td>
                    <td>#<?php echo $item['incidencia_id']; ?></td>
                    <td><?php echo htmlspecialchars($item['tipo']); ?></td>
                    <td><?php echo $item['estado']; ?></td>
                    <td><?php echo nl2br(htmlspecialchars($item['observaciones'])); ?></td>
                    <td>
                        <a href="programar.php?id=<?php echo $item['incidencia_id']; ?>">✏️ Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No hay incidencias programadas aún.</p>
<?php endif; ?>

<?php require_once("../../inc/footer.php"); ?>
