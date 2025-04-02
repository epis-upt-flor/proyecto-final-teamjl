<div class="row text-center mb-4">
    <div class="col-md-4">
        <div class="card border-danger">
            <div class="card-body">
                <h5 class="card-title text-danger">Pendientes</h5>
                <h2 id="pendientes" class="fw-bold">0</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-warning">
            <div class="card-body">
                <h5 class="card-title text-warning">En Desarrollo</h5>
                <h2 id="en_desarrollo" class="fw-bold">0</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-success">
            <div class="card-body">
                <h5 class="card-title text-success">Terminadas</h5>
                <h2 id="terminadas" class="fw-bold">0</h2>
            </div>
        </div>
    </div>
</div>

<canvas id="grafico" height="100"></canvas>

<script>
async function cargarDashboard() {
    const res = await fetch("http://localhost/proyecto-final-teamjl/gestion_incidencias_web/api/public/admin_dashboard/resumen_incidencias.php");
    const json = await res.json();

    if (json.success) {
        const datos = json.data;

        document.getElementById('pendientes').textContent = datos['Pendiente'] ?? 0;
        document.getElementById('en_desarrollo').textContent = datos['En Desarrollo'] ?? 0;
        document.getElementById('terminadas').textContent = datos['Terminado'] ?? 0;

        const ctx = document.getElementById('grafico').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Pendiente', 'En Desarrollo', 'Terminado'],
                datasets: [{
                    label: 'Cantidad de Incidencias',
                    data: [datos['Pendiente'], datos['En Desarrollo'], datos['Terminado']],
                    backgroundColor: ['#dc3545', '#ffc107', '#28a745']
                }]
            }
        });
    }
}
cargarDashboard();
</script>
