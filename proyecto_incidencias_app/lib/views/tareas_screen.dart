import 'package:flutter/material.dart';
import '../models/incidencia_model.dart';
import '../viewmodels/tareas_viewmodel.dart';
import 'detalle_incidencia_screen.dart';

class TareasScreen extends StatefulWidget {
  final Map<String, dynamic> user;

  const TareasScreen({super.key, required this.user});

  @override
  State<TareasScreen> createState() => _TareasScreenState();
}

class _TareasScreenState extends State<TareasScreen> {
  late TareasViewModel _viewModel;

  @override
  void initState() {
    super.initState();
    _viewModel = TareasViewModel(widget.user['id'], widget.user['token']);
    _viewModel.cargarIncidencias();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Tareas Asignadas'),
        backgroundColor: Colors.teal,
      ),
      body: AnimatedBuilder(
        animation: _viewModel,
        builder: (context, _) {
          if (_viewModel.isLoading) {
            return const Center(child: CircularProgressIndicator());
          }

          if (_viewModel.errorMessage != null) {
            return Center(child: Text(_viewModel.errorMessage!));
          }

          if (_viewModel.incidencias.isEmpty) {
            return const Center(child: Text('No tienes incidencias asignadas.'));
          }

          return ListView.builder(
            itemCount: _viewModel.incidencias.length,
            itemBuilder: (context, index) {
              final incidencia = _viewModel.incidencias[index];
              return _buildTareaCard(incidencia);
            },
          );
        },
      ),
    );
  }

  Widget _buildTareaCard(Incidencia incidencia) {
    final estadoNombre = incidencia.estado;

    final descripcion = incidencia.descripcion.isNotEmpty
        ? incidencia.descripcion
        : 'Sin descripción';

    final direccion = incidencia.direccion ?? '';
    final esPendiente = estadoNombre == 'Pendiente';

    return Card(
      elevation: 3,
      margin: const EdgeInsets.symmetric(vertical: 8, horizontal: 12),
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
      child: ListTile(
        leading: const Icon(Icons.assignment_outlined, color: Colors.teal),
        title: Text(descripcion),
        subtitle: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            if (direccion.isNotEmpty)
              Text("Dirección: $direccion"),
            Text("Estado actual: $estadoNombre"),
          ],
        ),
        trailing: esPendiente
            ? IconButton(
                icon: const Icon(Icons.check_circle_outline, color: Colors.green),
                tooltip: 'Marcar como Completado',
                onPressed: () {
                  _viewModel.actualizarEstado(
                    incidenciaId: incidencia.id,
                    nuevoEstadoId: 3,
                    token: widget.user['token'],
                    onSuccess: () {
                      ScaffoldMessenger.of(context).showSnackBar(
                        const SnackBar(content: Text('Estado actualizado')),
                      );
                    },
                    onError: () {
                      ScaffoldMessenger.of(context).showSnackBar(
                        const SnackBar(content: Text('Error al actualizar estado')),
                      );
                    },
                  );
                },
              )
            : const Icon(Icons.check_circle, color: Colors.grey),
        onTap: () {
          Navigator.push(
            context,
            MaterialPageRoute(
              builder: (context) => DetalleIncidenciaScreen(
                incidenciaId: incidencia.id,
                empleadoId: widget.user['id'],
                token: widget.user['token'],
              ),
            ),
          );
        },
      ),
    );
  }
}
