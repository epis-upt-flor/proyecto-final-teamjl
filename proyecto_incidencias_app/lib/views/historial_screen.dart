import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../viewmodels/historial_viewmodel.dart';
import '../models/incidencia_model.dart';

class HistorialScreen extends StatelessWidget {
  final int ciudadanoId;

  const HistorialScreen({super.key, required this.ciudadanoId});

  @override
  Widget build(BuildContext context) {
    return ChangeNotifierProvider<HistorialViewModel>(
      create: (_) => HistorialViewModel()..cargarHistorial(ciudadanoId),
      child: Scaffold(
        appBar: AppBar(
          title: const Text('Historial de Incidencias'),
          backgroundColor: Colors.teal,
        ),
        body: Consumer<HistorialViewModel>(
          builder: (context, viewModel, _) {
            if (viewModel.isLoading) {
              return const Center(child: CircularProgressIndicator());
            } else if (viewModel.errorMessage != null) {
              return Center(child: Text(viewModel.errorMessage!));
            } else if (viewModel.incidencias.isEmpty) {
              return const Center(child: Text('No hay incidencias registradas.'));
            }

            return ListView.builder(
              itemCount: viewModel.incidencias.length,
              itemBuilder: (context, index) {
                return _buildIncidenciaCard(viewModel.incidencias[index]);
              },
            );
          },
        ),
      ),
    );
  }

  Widget _buildIncidenciaCard(Incidencia incidencia) {
    String estado = incidencia.estado;
    IconData iconoEstado;
    Color colorIcono;

    switch (estado) {
      case 'Terminado':
        iconoEstado = Icons.check_circle;
        colorIcono = Colors.green;
        break;
      case 'Pendiente':
        iconoEstado = Icons.pending;
        colorIcono = Colors.grey;
        break;
      case 'En Desarrollo':
        iconoEstado = Icons.loop;
        colorIcono = Colors.blue;
        break;
      default:
        iconoEstado = Icons.error_outline;
        colorIcono = Colors.red;
    }

    return Card(
      margin: const EdgeInsets.symmetric(vertical: 6, horizontal: 12),
      child: ListTile(
        leading: Icon(iconoEstado, color: colorIcono),
        title: Text(
          incidencia.tipo ?? 'Tipo desconocido',
          style: const TextStyle(fontWeight: FontWeight.bold),
        ),
        subtitle: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text('Descripción: ${incidencia.descripcion}'),
            Text('Estado: $estado'),
            Text('Fecha: ${incidencia.fechaReporte}'),
          ],
        ),
        enabled: false,
      ),
    );
  }
}
