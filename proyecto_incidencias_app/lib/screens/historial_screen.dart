import 'package:flutter/material.dart';
import '../services/incidencia_service.dart';

class HistorialScreen extends StatefulWidget {
  const HistorialScreen({Key? key}) : super(key: key);

  @override
  State<HistorialScreen> createState() => _HistorialScreenState();
}

class _HistorialScreenState extends State<HistorialScreen> {
  late Future<List<Map<String, dynamic>>> _incidencias;

  @override
  void initState() {
    super.initState();
    _incidencias = IncidenciaService.obtenerTodasLasIncidencias();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Historial de Incidencias'),
        backgroundColor: Colors.teal,
      ),
      body: FutureBuilder<List<Map<String, dynamic>>>(
        future: _incidencias,
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return const Center(child: CircularProgressIndicator());
          } else if (snapshot.hasError) {
            return const Center(child: Text('Error al cargar incidencias.'));
          } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
            return const Center(child: Text('No hay incidencias registradas.'));
          }

          final incidencias = snapshot.data!;
          return ListView.builder(
            itemCount: incidencias.length,
            itemBuilder: (context, index) {
              final incidencia = incidencias[index];
              return _buildIncidenciaCard(incidencia);
            },
          );
        },
      ),
    );
  }

  Widget _buildIncidenciaCard(Map<String, dynamic> incidencia) {
    String estado = incidencia['estado'] ?? 'Desconocido';
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
          incidencia['tipo'] ?? 'Tipo desconocido',
          style: const TextStyle(fontWeight: FontWeight.bold),
        ),
        subtitle: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text('Descripción: ${incidencia['descripcion'] ?? 'Sin descripción'}'),
            Text('Estado: $estado'),
            Text('Fecha: ${incidencia['fecha_reporte'] ?? 'Sin fecha'}'),
          ],
        ),
        
        enabled: false,
      ),
    );
  }
}
