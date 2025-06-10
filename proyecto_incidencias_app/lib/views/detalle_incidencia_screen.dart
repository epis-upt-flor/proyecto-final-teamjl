import 'dart:typed_data';
import 'package:flutter/material.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';
import '../viewmodels/detalle_incidencia_viewmodel.dart';

class DetalleIncidenciaScreen extends StatefulWidget {
  final int incidenciaId;
  final int empleadoId;
  final String token;

  const DetalleIncidenciaScreen({
    Key? key,
    required this.incidenciaId,
    required this.empleadoId,
    required this.token,
  }) : super(key: key);

  @override
  State<DetalleIncidenciaScreen> createState() => _DetalleIncidenciaScreenState();
}

class _DetalleIncidenciaScreenState extends State<DetalleIncidenciaScreen> {
  late DetalleIncidenciaViewModel _viewModel;
  late GoogleMapController _mapController;

  @override
  void initState() {
    super.initState();
    _viewModel = DetalleIncidenciaViewModel();
    _viewModel.cargarDetalle(widget.empleadoId, widget.incidenciaId, widget.token);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Detalle de Incidencia'),
        backgroundColor: Colors.teal,
      ),
      body: AnimatedBuilder(
        animation: _viewModel,
        builder: (context, _) {
          if (_viewModel.isLoading) {
            return const Center(child: CircularProgressIndicator());
          }

          final incidencia = _viewModel.incidencia;
          if (incidencia == null) {
            return const Center(child: Text('No se pudo cargar la incidencia.'));
          }

          return Padding(
            padding: const EdgeInsets.all(16),
            child: ListView(
              children: [
                _buildSection('Descripción', incidencia['descripcion']),
                _buildSection('Estado', incidencia['estado']),
                _buildSection('Fecha de Reporte', incidencia['fecha_reporte']),
                const SizedBox(height: 16),

                if (incidencia['foto'] != null && incidencia['foto'] is Uint8List)
                  Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      const Text(
                        'Imagen Reportada',
                        style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
                      ),
                      const SizedBox(height: 8),
                      ClipRRect(
                        borderRadius: BorderRadius.circular(10),
                        child: Image.memory(
                          incidencia['foto'],
                          height: 200,
                          fit: BoxFit.cover,
                          errorBuilder: (context, error, stackTrace) {
                            return const Text('Imagen no disponible');
                          },
                        ),
                      ),
                    ],
                  )
                else
                  const Text('No hay imagen disponible.'),

                const SizedBox(height: 24),

                if (incidencia['latitud'] != null && incidencia['longitud'] != null)
                  Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      const Text(
                        'Ubicación Geográfica',
                        style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
                      ),
                      const SizedBox(height: 8),
                      SizedBox(
                        height: 250,
                        child: GoogleMap(
                          initialCameraPosition: CameraPosition(
                            target: LatLng(
                              double.tryParse(incidencia['latitud'].toString()) ?? 0.0,
                              double.tryParse(incidencia['longitud'].toString()) ?? 0.0,
                            ),
                            zoom: 16,
                          ),
                          onMapCreated: (controller) {
                            _mapController = controller;
                          },
                          markers: {
                            Marker(
                              markerId: const MarkerId('incidencia'),
                              position: LatLng(
                                double.tryParse(incidencia['latitud'].toString()) ?? 0.0,
                                double.tryParse(incidencia['longitud'].toString()) ?? 0.0,
                              ),
                              infoWindow: const InfoWindow(title: 'Ubicación de la incidencia'),
                            ),
                          },
                        ),
                      ),
                    ],
                  )
                else
                  const Text('No hay coordenadas disponibles.'),
              ],
            ),
          );
        },
      ),
    );
  }

  Widget _buildSection(String title, String? content) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 12),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(title, style: const TextStyle(fontSize: 16, fontWeight: FontWeight.bold)),
          Text(content ?? 'No disponible'),
        ],
      ),
    );
  }
}
