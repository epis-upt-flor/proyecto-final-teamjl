import 'package:flutter/material.dart';
import '../services/incidencias_empleado_service.dart';
import 'detalle_incidencia_screen.dart';

class TareasScreen extends StatefulWidget {
  final Map<String, dynamic> user;

  const TareasScreen({Key? key, required this.user}) : super(key: key);

  @override
  State<TareasScreen> createState() => _TareasScreenState();
}

class _TareasScreenState extends State<TareasScreen> {
  List<Map<String, dynamic>> _incidencias = [];
  bool _isLoading = true;

  @override
  void initState() {
    super.initState();
    _cargarIncidencias();
  }

  Future<void> _cargarIncidencias() async {
    final resultado = await IncidenciasEmpleadoService.obtenerIncidenciasAsignadas(widget.user['id']);
    setState(() {
      _incidencias = resultado;
      _isLoading = false;
    });
  }

  Future<void> _actualizarEstado(int incidenciaId, int nuevoEstadoId) async {
    final exito = await IncidenciasEmpleadoService.actualizarEstado(incidenciaId, nuevoEstadoId);
    if (exito) {
      ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text('Estado actualizado')));
      _cargarIncidencias();
    } else {
      ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text('Error al actualizar estado')));
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Tareas Asignadas'),
        backgroundColor: Colors.teal,
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: _isLoading
            ? const Center(child: CircularProgressIndicator())
            : _incidencias.isEmpty
                ? Center(
                    child: Text(
                      'No tienes incidencias asignadas.',
                      style: TextStyle(fontSize: 16, color: Colors.grey[600]),
                    ),
                  )
                : ListView.builder(
                    itemCount: _incidencias.length,
                    itemBuilder: (context, index) {
                      final incidencia = _incidencias[index];
                      return _buildTareaCard(incidencia);
                    },
                  ),
      ),
    );
  }

  Widget _buildTareaCard(Map<String, dynamic> incidencia) {
    final estadoNombre = incidencia['estado'] ?? 'Desconocido';
    final esPendiente = estadoNombre == 'Pendiente';

    return Card(
      elevation: 3,
      margin: const EdgeInsets.symmetric(vertical: 8),
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
      child: ListTile(
        leading: const Icon(Icons.assignment_outlined, color: Colors.teal),
        title: Text(incidencia['descripcion'] ?? 'Sin descripción'),
        subtitle: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            if (incidencia['direccion'] != null)
              Text("Dirección: ${incidencia['direccion']}"),
            Text("Estado actual: $estadoNombre"),
          ],
        ),
        trailing: esPendiente
            ? IconButton(
                icon: const Icon(Icons.check_circle_outline, color: Colors.green),
                tooltip: 'Marcar como Completado',
                onPressed: () {
                  _actualizarEstado(incidencia['id'], 3); // Estado "Completado"
                },
              )
            : const Icon(Icons.check_circle, color: Colors.grey),
        onTap: () {
          Navigator.push(
            context,
            MaterialPageRoute(
              builder: (context) => DetalleIncidenciaScreen(
                incidenciaId: incidencia['id'],
                empleadoId: widget.user['id'], // ✅ ahora pasamos también el empleadoId
              ),
            ),
          );
        },
      ),
    );
  }
}
