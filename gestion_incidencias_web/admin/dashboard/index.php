<?php
require_once("../../inc/auth.php");
require_once("../../inc/db.php");
require_once("../../inc/config.php");
require_once("../../inc/header.php");
?>

<h2>Panel del Administrador</h2>
<p>Bienvenido, <strong><?php echo htmlspecialchars($_SESSION['admin_nombre']); ?></strong></p>

<hr>

<h3>📊 Resumen de Incidencias</h3>

<?php
$resumen = [
    'Pendiente' => 0,
    'En Desarrollo' => 0,
    'Terminado' => 0
];

try {
    $stmt = $pdo->query("
        SELECT ei.nombre AS estado, COUNT(*) AS total
        FROM incidencia i
        INNER JOIN estado_incidencia ei ON i.estado_id = ei.id
        GROUP BY ei.nombre
    ");

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $estado = $row['estado'];
        $resumen[$estado] = $row['total'];
    }
} catch (Exception $e) {
    echo "<p>Error al cargar el resumen: " . $e->getMessage() . "</p>";
}
?>

<table>
    <thead>
        <tr>
            <th>Estado</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>📌 Pendiente</td>
            <td><strong><?php echo $resumen['Pendiente']; ?></strong></td>
        </tr>
        <tr>
            <td>🚧 En Desarrollo</td>
            <td><strong><?php echo $resumen['En Desarrollo']; ?></strong></td>
        </tr>
        <tr>
            <td>✅ Terminado</td>
            <td><strong><?php echo $resumen['Terminado']; ?></strong></td>
        </tr>
    </tbody>
</table>

<hr>

<h3>🧭 Accesos Rápidos</h3>
<ul>
    <li><a href="../incidencias/">Ver todas las incidencias</a></li>
    <li><a href="../empleados/">Gestión de empleados</a></li>
    <li><a href="../reporte/">Reportes y estadísticas</a></li>
    <li><a href="../incidencias/calendario.php">Calendario de programación</a></li>
</ul>

<?php require_once("../../inc/footer.php"); ?>
