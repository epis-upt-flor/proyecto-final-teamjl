<?php ?>

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
        <th>Prioridad</th>
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

            <td>
              <?php if ($inc['estado'] === 'Pendiente'): ?>
                <select class="form-select form-select-sm"
                        id="select-prio-<?= $inc['id'] ?>">
                  <option value="">Prioridad…</option>
                  <?php foreach ($prioridades as $p): ?>
                    <option value="<?= htmlspecialchars($p['id']) ?>">
                      <?= htmlspecialchars($p['prioridad']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              <?php else: ?>
                <?= !empty($inc['prioridad'])
                     ? htmlspecialchars($inc['prioridad'])
                     : '<span class="text-muted">—</span>'
                ?>
              <?php endif; ?>
            </td>

            <td><?= htmlspecialchars($inc['descripcion']) ?></td>
            <td><?= htmlspecialchars($inc['latitud']) ?>, <?= htmlspecialchars($inc['longitud']) ?></td>
            <td><?= htmlspecialchars($inc['fecha_reporte']) ?></td>

            <td>
              <?php if ($inc['estado'] === 'Pendiente'): ?>
                <div class="d-flex">
                  <select class="form-select form-select-sm"
                          id="select-emp-<?= $inc['id'] ?>">
                    <option value="">Empleado…</option>
                    <?php foreach ($empleados as $emp): ?>
                      <option value="<?= htmlspecialchars($emp['id']) ?>">
                        <?= htmlspecialchars($emp['nombre'] . ' ' . $emp['apellido']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <button
                    onclick="assignIncidencia(<?= $inc['id'] ?>)"
                    class="btn btn-sm btn-primary ms-2"
                  >✔</button>
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
  const API_TOKEN = '<?= $_SESSION['user_token'] ?? '' ?>';  // <— aquí

  function assignIncidencia(id) {
    const selEmp  = document.getElementById(`select-emp-${id}`);
    const selPrio = document.getElementById(`select-prio-${id}`);
    const empleado_id  = parseInt(selEmp.value, 10);
    const prioridad_id = parseInt(selPrio.value, 10);

    if (!empleado_id || !prioridad_id) {
      return alert('Seleccione empleado y prioridad.');
    }

    fetch(`${API_BASE}admin_dashboard/asignar_incidencia.php`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer ' + API_TOKEN
      },
      body: JSON.stringify({ incidencia_id: id, empleado_id, prioridad_id })
    })
    .then(r => r.json())
    .then(json => {
      if (json.success) {
        alert('✅ Incidencia actualizada con prioridad.');
        window.location.reload();
      } else {
        alert('❌ ' + (json.message||'Error al asignar'));
      }
    })
    .catch(() => alert('❌ No se pudo conectar.'));
  }
</script>