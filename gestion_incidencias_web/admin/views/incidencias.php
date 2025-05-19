<h2 class="mb-4 text-center"><?= htmlspecialchars($title ?? 'Listado de Incidencias') ?></h2>

<?php if (!empty($errorInc)): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($errorInc) ?></div>
<?php endif; ?>

<?php if (!empty($errorEmp)): ?>
  <div class="alert alert-warning"><?= htmlspecialchars($errorEmp) ?></div>
<?php endif; ?>

<div class="table-responsive">
  <table class="table table-bordered table-hover bg-white">
    <thead class="table-light">
      <tr>
        <th>ID</th>
        <th>Tipo</th>
        <th>Estado</th>
        <th>Prioridad</th>        <!-- Nueva columna -->
        <th>Descripción</th>
        <th>Ubicación</th>
        <th>Fecha</th>
        <th>Asignar a</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($incidencias)): ?>
        <tr>
          <td colspan="8" class="text-center text-muted">No hay incidencias reportadas.</td>
        </tr>
      <?php else: ?>
        <?php foreach ($incidencias as $inc): ?>
          <tr>
            <td><?= htmlspecialchars($inc['id']) ?></td>
            <td><?= htmlspecialchars($inc['tipo']) ?></td>
            <td><?= htmlspecialchars($inc['estado']) ?></td>

            <!-- Nuevo bloque: mostramos el nivel de prioridad -->
            <td>
              <?= isset($inc['prioridad']) 
                    ? htmlspecialchars($inc['prioridad']) 
                    : '<span class="text-muted">—</span>' 
              ?>
            </td>

            <td><?= htmlspecialchars($inc['descripcion']) ?></td>
            <td><?= htmlspecialchars($inc['latitud']) ?>, <?= htmlspecialchars($inc['longitud']) ?></td>
            <td><?= htmlspecialchars($inc['fecha_reporte']) ?></td>
            <td>
              <?php if ($inc['estado'] === 'Pendiente'): ?>
                <div class="d-flex">
                  <select class="form-select form-select-sm" id="select-<?= $inc['id'] ?>">
                    <option value="">Seleccionar</option>
                    <?php foreach ($empleados as $emp): ?>
                      <option value="<?= htmlspecialchars($emp['id']) ?>">
                        <?= htmlspecialchars($emp['nombre'] . ' ' . $emp['apellido']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <button
                    onclick="assignEmpleado(<?= $inc['id'] ?>)"
                    class="btn btn-sm btn-primary ms-2">
                    Asignar
                  </button>
                </div>
              <?php else: ?>
                <span class="text-muted">—</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<script>
  const API_BASE = '<?= API_BASE ?>';

  function assignEmpleado(incidenciaId) {
    const select = document.getElementById(`select-${incidenciaId}`);
    const empleadoId = select.value;
    if (!empleadoId) {
      return alert('Seleccione un empleado.');
    }

    fetch(`${API_BASE}admin_dashboard/asignar_incidencia.php`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ incidencia_id: incidenciaId, empleado_id: parseInt(empleadoId, 10) })
    })
    .then(res => res.json())
    .then(json => {
      if (json.success) {
        alert('✅ Incidencia asignada correctamente');
        window.location.reload();
      } else {
        alert('❌ Error: ' + (json.message || 'Falló la asignación'));
      }
    })
    .catch(() => {
      alert('❌ No se pudo conectar al servidor.');
    });
  }
</script>
