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

$incidencia_id = $_GET['id'];

// Obtener lista de empleados
$empleados = $pdo->query("SELECT id, nombre, apellido FROM empleado ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);

// Obtener asignación actual si existe
$stmt = $pdo->prepare("SELECT asignado_a FROM incidencia WHERE id = :id");
$stmt->execute(['id' => $incidencia_id]);
$incidencia = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$incidencia) {
    echo "<p>Incidencia no encontrada.</p>";
    require_once("../../inc/footer.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $empleado_id = $_POST['empleado_id'];

    $update = $pdo->prepare("UPDATE incidencia SET asignado_a = :empleado_id WHERE id = :id");
    $update->execute([
        'empleado_id' => $empleado_id,
        'id' => $incidencia_id
    ]);

    echo "<p>✅ Incidencia asignada correctamente.</p>";
    echo "<p><a href='index.php'>← Volver al listado</a></p>";
    require_once("../../inc/footer.php");
    exit();
}
?>

<h2>👷 Asignar Incidencia #<?php echo $incidencia_id; ?> a un Empleado</h2>
<a href="index.php">← Volver al listado</a>

<form method="POST">
    <label for="empleado_id">Selecciona un empleado:</label>
    <select name="empleado_id" required>
        <?php foreach ($empleados as $emp): ?>
            <option value="<?php echo $emp['id']; ?>"
                <?php echo $emp['id'] == $incidencia['asignado_a'] ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($emp['nombre'] . " " . $emp['apellido']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <input type="submit" value="Asignar">
</form>

<?php require_once("../../inc/footer.php"); ?>
