<h2 class="mb-4 text-center">Todas las Incidencias Reportadas</h2>

<div class="table-responsive">
    <table class="table table-bordered table-hover bg-white">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th>Descripción</th>
                <th>Ubicación</th>
                <th>Fecha</th>
                <th>Asignar a</th>
            </tr>
        </thead>
        <tbody id="tabla-incidencias">
            <tr><td colspan="7" class="text-center">Cargando...</td></tr>
        </tbody>
    </table>
</div>

<script>
    let empleados = [];

    async function cargarEmpleados() {
        try {
            const res = await fetch("http://localhost/proyecto-final-teamjl/gestion_incidencias_web/api/public/admin_dashboard/empleados.php");
            const json = await res.json();
            empleados = json.success ? json.data : [];
        } catch {
            empleados = [];
        }
    }

    async function asignarEmpleado(incidenciaId) {
        const select = document.getElementById(`select-${incidenciaId}`);
        const empleadoId = select.value;

        if (!empleadoId) return alert("Seleccione un empleado");

        const respuesta = await fetch("http://localhost/proyecto-final-teamjl/gestion_incidencias_web/api/public/admin_dashboard/asignar_incidencia.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ incidencia_id: incidenciaId, empleado_id: parseInt(empleadoId) })
        });

        const json = await respuesta.json();
        if (json.success) {
            alert("✅ Incidencia asignada correctamente");
            cargarIncidencias();
        } else {
            alert("❌ Error al asignar: " + json.message);
        }
    }

    async function cargarIncidencias() {
        const cuerpo = document.getElementById("tabla-incidencias");
        cuerpo.innerHTML = `<tr><td colspan="7" class="text-center">Cargando...</td></tr>`;

        try {
            const res = await fetch("http://localhost/proyecto-final-teamjl/gestion_incidencias_web/api/public/admin_dashboard/incidencias.php");
            const json = await res.json();

            cuerpo.innerHTML = "";

            if (!json.success) {
                cuerpo.innerHTML = `<tr><td colspan="7" class="text-danger text-center">${json.message}</td></tr>`;
                return;
            }

            json.data.forEach(inc => {
                let asignarHTML = "-";
                if (inc.estado === "Pendiente") {
                    const opciones = empleados.map(emp =>
                        `<option value="${emp.id}">${emp.nombre} ${emp.apellido}</option>`
                    ).join("");

                    asignarHTML = `
                        <div class="d-flex">
                            <select class="form-select form-select-sm" id="select-${inc.id}">
                                <option value="">Seleccionar</option>
                                ${opciones}
                            </select>
                            <button onclick="asignarEmpleado(${inc.id})" class="btn btn-sm btn-primary ms-2">Asignar</button>
                        </div>`;
                }

                const fila = `
                    <tr>
                        <td>${inc.id}</td>
                        <td>${inc.tipo}</td>
                        <td>${inc.estado}</td>
                        <td>${inc.descripcion}</td>
                        <td>${inc.latitud}, ${inc.longitud}</td>
                        <td>${inc.fecha_reporte}</td>
                        <td>${asignarHTML}</td>
                    </tr>
                `;
                cuerpo.innerHTML += fila;
            });

        } catch (error) {
            cuerpo.innerHTML = `<tr><td colspan="7" class="text-danger text-center">Error de conexión al servidor</td></tr>`;
        }
    }

    (async () => {
        await cargarEmpleados();
        await cargarIncidencias();
    })();
</script>
