import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';
import '../services/incidencias_empleado_service.dart';

class DetalleIncidenciaScreen extends StatefulWidget {
  final int incidenciaId;
  final int empleadoId;

  const DetalleIncidenciaScreen({
    Key? key,
    required this.incidenciaId,
    required this.empleadoId,
  }) : super(key: key);

  @override
  State<DetalleIncidenciaScreen> createState() => _DetalleIncidenciaScreenState();
}

class _DetalleIncidenciaScreenState extends State<DetalleIncidenciaScreen> {
  Map<String, dynamic>? _incidencia;
  bool _isLoading = true;
  late GoogleMapController _mapController;

  @override
  void initState() {
    super.initState();
    _cargarDetalle();
  }

  Future<void> _cargarDetalle() async {
    final resultado = await IncidenciasEmpleadoService.obtenerIncidenciaPorId(
      widget.empleadoId,
      widget.incidenciaId,
    );
    setState(() {
      _incidencia = resultado;
      _isLoading = false;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Detalle de Incidencia'),
        backgroundColor: Colors.teal,
      ),
      body: _isLoading
          ? const Center(child: CircularProgressIndicator())
          : _incidencia == null
              ? const Center(child: Text('No se pudo cargar la incidencia.'))
              : Padding(
                  padding: const EdgeInsets.all(16),
                  child: ListView(
                    children: [
                      _buildSection('Descripción', _incidencia!['descripcion']),
                      _buildSection('Estado', _incidencia!['estado']),
                      _buildSection('Fecha de Reporte', _incidencia!['fecha_reporte']),
                      const SizedBox(height: 16),

                      // Imagen
                      if (_incidencia!['foto'] != null && _incidencia!['foto'].toString().isNotEmpty)
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
                                base64Decode(_incidencia!['foto']),
                                height: 200,
                                fit: BoxFit.cover,
                              ),
                            ),
                          ],
                        )
                      else
                        const Text('No hay imagen disponible.'),

                      const SizedBox(height: 24),

                      // Mapa
                      if (_incidencia!['latitud'] != null && _incidencia!['longitud'] != null)
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
                                    double.tryParse(_incidencia!['latitud'].toString()) ?? 0.0,
                                    double.tryParse(_incidencia!['longitud'].toString()) ?? 0.0,
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
                                      double.tryParse(_incidencia!['latitud'].toString()) ?? 0.0,
                                      double.tryParse(_incidencia!['longitud'].toString()) ?? 0.0,
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
