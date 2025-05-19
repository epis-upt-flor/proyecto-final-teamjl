<?php
$title = 'Reportes Estadísticos';
?>

<h2 class="mb-4 text-center"><?= htmlspecialchars($title) ?></h2>

<form class="row g-3 mb-4 justify-content-center" method="get" action="<?= url('reporte') ?>">
  <input type="hidden" name="path" value="reporte">
  <div class="col-auto">
    <label for="inicio" class="form-label">Desde:</label>
    <input
      type="date"
      id="inicio"
      name="inicio"
      class="form-control"
      value="<?= htmlspecialchars($inicio) ?>"
    >
  </div>
  <div class="col-auto">
    <label for="fin" class="form-label">Hasta:</label>
    <input
      type="date"
      id="fin"
      name="fin"
      class="form-control"
      value="<?= htmlspecialchars($fin) ?>"
    >
  </div>
  <div class="col-auto align-self-end">
    <button type="submit" class="btn btn-primary">✔ Aplicar rango</button>
  </div>
</form>

<div class="row mb-5">
  <div class="col-md-6">
    <h5 class="text-center">📊 Incidencias por Estado</h5>
    <canvas id="graficoEstado"></canvas>
  </div>
  <div class="col-md-6">
    <h5 class="text-center">📌 Incidencias por Tipo</h5>
    <canvas id="graficoTipo"></canvas>
  </div>
</div>

<div class="text-center mb-4">
  <!-- Generar PDF agrupado por empleado -->
  <a
    href="<?= url('reporte/exportPdf') . "&inicio={$inicio}&fin={$fin}" ?>"
    class="btn btn-outline-success mx-2"
  >
    📄 PDF por Empleado
  </a>
  <!-- Generar Excel agrupado por empleado -->
  <a
    href="<?= url('reporte/exportExcel') . "&inicio={$inicio}&fin={$fin}" ?>"
    class="btn btn-outline-secondary mx-2"
  >
    📊 Excel por Empleado
  </a>
</div>

<script>
  const porEstado = <?= json_encode($por_estado, JSON_THROW_ON_ERROR) ?>;
  const porTipo   = <?= json_encode($por_tipo, JSON_THROW_ON_ERROR) ?>;

  // Gráfico de estados
  const estados = porEstado.map(e => e.estado);
  const totalesEstado = porEstado.map(e => e.total);
  new Chart(document.getElementById('graficoEstado'), {
    type: 'doughnut',
    data: {
      labels: estados,
      datasets: [{
        data: totalesEstado,
        backgroundColor: ['#dc3545','#ffc107','#28a745','#0dcaf0']
      }]
    }
  });

  // Gráfico de tipos
  const tipos = porTipo.map(t => t.tipo);
  const totalesTipo = porTipo.map(t => t.total);
  new Chart(document.getElementById('graficoTipo'), {
    type: 'bar',
    data: {
      labels: tipos,
      datasets: [{
        data: totalesTipo,
        backgroundColor: '#0d6efd'
      }]
    }
  });
</script>
