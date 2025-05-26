<?php ?>

<div class="row text-center mb-4">
  <div class="col-md-4">
    <div class="card border-danger">
      <div class="card-body">
        <h5 class="card-title text-danger">Pendientes</h5>
        <h2><?= $pendientes ?></h2>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card border-warning">
      <div class="card-body">
        <h5 class="card-title text-warning">En Desarrollo</h5>
        <h2><?= $en_desarrollo ?></h2>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card border-success">
      <div class="card-body">
        <h5 class="card-title text-success">Terminadas</h5>
        <h2><?= $terminadas ?></h2>
      </div>
    </div>
  </div>
</div>

<canvas id="grafico" height="100"></canvas>

<script>
const datos = [
  <?= $pendientes ?>,
  <?= $en_desarrollo ?>,
  <?= $terminadas ?>
];
const ctx = document.getElementById('grafico').getContext('2d');
new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ['Pendiente','En Desarrollo','Terminado'],
    datasets: [{
      label: 'Cantidad',
      data: datos,
      backgroundColor: ['#dc3545','#ffc107','#28a745'],
    }]
  }
});
</script>