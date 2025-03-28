<?php
require_once("../../inc/auth.php");
require_once("../../inc/db.php");
require_once("../../inc/config.php");
require_once("../../inc/header.php");
?>

<h2>👷 Lista de Empleados Registrados</h2>
<p>Estos empleados se han registrado desde la app móvil. Solo puedes visualizarlos desde esta sección.</p>

<?php
try {
    $stmt = $pdo->query("SELECT id, dni, nombre, apellido, email FROM empleado ORDER BY id DESC");
    $empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "<p>Error al obtener empleados: " . $e->getMessage() . "</p>";
}
?>

<?php if (!empty($empleados)): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>DNI</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($empleados as $empleado): ?>
                <tr>
                    <td><?php echo $empleado['id']; ?></td>
                    <td><?php echo htmlspecialchars($empleado['dni']); ?></td>
                    <td><?php echo htmlspecialchars($empleado['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($empleado['apellido']); ?></td>
                    <td><?php echo htmlspecialchars($empleado['email']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No se encontraron empleados registrados.</p>
<?php endif; ?>

<?php require_once("../../inc/footer.php"); ?>
