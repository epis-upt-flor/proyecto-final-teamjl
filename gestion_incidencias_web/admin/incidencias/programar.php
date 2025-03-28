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

// Obtener programación existente
$stmt = $pdo->prepare("SELECT * FROM calendario_incidencia WHERE incidencia_id = :id");
$stmt->execute(['id' => $incidencia_id]);
$programacion = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha = $_POST['fecha'];
    $obs = $_POST['observaciones'];

    if ($programacion) {
        $update = $pdo->prepare("UPDATE calendario_incidencia SET fecha_programada = :fecha, observaciones = :obs WHERE incidencia_id = :id");
        $update->execute([
            'fecha' => $fecha,
            'obs' => $obs,
            'id' => $incidencia_id
        ]);
    } else {
        $insert = $pdo->prepare("INSERT INTO calendario_incidencia (incidencia_id, fecha_programada, observaciones) VALUES (:id, :fecha, :obs)");
        $insert->execute([
            'id' => $incidencia_id,
            'fecha' => $fecha,
            'obs' => $obs
        ]);
    }

    echo "<p>✅ Intervención programada correctamente.</p>";
    echo "<p><a href='calendario.php'>← Volver al calendario</a></p>";
    require_once("../../inc/footer.php");
    exit();
}
?>

<h2>📆 Programar Intervención</h2>
<p>Asigna una fecha de intervención para la incidencia #<?php echo $incidencia_id; ?>.</p>

<form method="POST">
    <label>Fecha de intervención:</label>
    <input type="date" name="fecha" value="<?php echo $programacion['fecha_programada'] ?? ''; ?>" required>

    <label>Observaciones:</label>
    <textarea name="observaciones" rows="4"><?php echo $programacion['observaciones'] ?? ''; ?></textarea>

    <input type="submit" value="Guardar programación">
</form>

<p><a href="calendario.php">← Volver al calendario</a></p>

<?php require_once("../../inc/footer.php"); ?>
