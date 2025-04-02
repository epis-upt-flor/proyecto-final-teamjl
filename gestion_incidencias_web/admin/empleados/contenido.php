<h2 class="mb-4 text-center">Listado de Empleados</h2>

<div class="table-responsive">
    <table class="table table-bordered table-hover bg-white">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>DNI</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
            </tr>
        </thead>
        <tbody id="tabla-empleados">
            <tr><td colspan="5" class="text-center">Cargando...</td></tr>
        </tbody>
    </table>
</div>

<script>
    async function cargarEmpleados() {
        try {
            const res = await fetch("http://localhost/proyecto-final-teamjl/gestion_incidencias_web/api/public/admin_dashboard/empleados.php");
            const json = await res.json();

            const cuerpo = document.getElementById("tabla-empleados");
            cuerpo.innerHTML = "";

            if (!json.success) {
                cuerpo.innerHTML = `<tr><td colspan="5" class="text-danger text-center">${json.message}</td></tr>`;
                return;
            }

            if (json.data.length === 0) {
                cuerpo.innerHTML = `<tr><td colspan="5" class="text-muted text-center">No hay empleados registrados.</td></tr>`;
                return;
            }

            json.data.forEach(emp => {
                const fila = `
                    <tr>
                        <td>${emp.id}</td>
                        <td>${emp.dni}</td>
                        <td>${emp.nombre}</td>
                        <td>${emp.apellido}</td>
                        <td>${emp.email}</td>
                    </tr>
                `;
                cuerpo.innerHTML += fila;
            });
        } catch (error) {
            document.getElementById("tabla-empleados").innerHTML = `<tr><td colspan="5" class="text-danger text-center">Error de conexión al servidor</td></tr>`;
        }
    }

    cargarEmpleados();
</script>
