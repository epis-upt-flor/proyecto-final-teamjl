<?php
require_once("../../inc/auth.php");
require_once("../../inc/db.php");
require_once("../../inc/config.php");
require_once("../../inc/header.php");
?>

<h2>📋 Lista de Incidencias Reportadas</h2>
<p>Estas incidencias fueron enviadas por ciudadanos desde la app móvil. Puedes revisarlas y asignarlas a un empleado.</p>

<?php
try {
    $stmt = $pdo->query("
        SELECT i.id, ti.nombre AS tipo, i.fecha_reporte, ei.nombre AS estado, 
               i.latitud, i.longitud
        FROM incidencia i
        JOIN tipo_incidencia ti ON i.tipo_id = ti.id
        JOIN estado_incidencia ei ON i.estado_id = ei.id
        ORDER BY i.fecha_reporte DESC
    ");
    $incidencias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "<p>Error al cargar incidencias: " . $e->getMessage() . "</p>";
}
?>

<?php if (!empty($incidencias)): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Ubicación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($incidencias as $inc): ?>
                <tr>
                    <td>#<?php echo $inc['id']; ?></td>
                    <td><?php echo htmlspecialchars($inc['tipo']); ?></td>
                    <td><?php echo $inc['fecha_reporte']; ?></td>
                    <td><?php echo $inc['estado']; ?></td>
                    <td>
                        Lat: <?php echo $inc['latitud']; ?><br>
                        Lon: <?php echo $inc['longitud']; ?><br>
                        <a href="https://www.google.com/maps?q=<?php echo $inc['latitud'] . ',' . $inc['longitud']; ?>" target="_blank">Ver en mapa</a>
                    </td>
                    <td>
                        <a href="ver.php?id=<?php echo $inc['id']; ?>">🔎 Ver</a> |
                        <a href="asignar.php?id=<?php echo $inc['id']; ?>">👷 Asignar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No se encontraron incidencias registradas.</p>
<?php endif; ?>

<?php require_once("../../inc/footer.php"); ?>
