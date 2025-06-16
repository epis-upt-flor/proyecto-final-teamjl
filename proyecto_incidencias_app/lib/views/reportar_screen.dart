import 'package:flutter/material.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';
import 'package:provider/provider.dart';

import '../viewmodels/reportar_viewmodel.dart';

class ReportarScreen extends StatelessWidget {
  final int ciudadanoId;

  const ReportarScreen({super.key, required this.ciudadanoId});

  @override
  Widget build(BuildContext context) {
    return ChangeNotifierProvider<ReportarViewModel>(
      create: (_) => ReportarViewModel()..cargarTipos(),
      child: Scaffold(
        appBar: AppBar(
          title: const Text('Reportar Incidencia'),
          backgroundColor: Colors.teal,
        ),
        body: Consumer<ReportarViewModel>(
          builder: (context, viewModel, _) {
            return SingleChildScrollView(
              padding: const EdgeInsets.all(20),
              child: Column(
                children: [
                  TextField(
                    controller: viewModel.descripcionController,
                    decoration: const InputDecoration(
                      labelText: 'Descripción',
                      border: OutlineInputBorder(),
                    ),
                    maxLines: 3,
                  ),
                  const SizedBox(height: 16),
                  TextField(
                    controller: viewModel.direccionController,
                    decoration: const InputDecoration(
                      labelText: 'Dirección',
                      border: OutlineInputBorder(),
                    ),
                  ),
                  const SizedBox(height: 16),
                  TextField(
                    controller: viewModel.zonaController,
                    decoration: const InputDecoration(
                      labelText: 'Zona',
                      border: OutlineInputBorder(),
                    ),
                  ),
                  const SizedBox(height: 16),

                  // Dropdown tipos
                  if (viewModel.tipos.isNotEmpty)
                    DropdownButton<int>(
                      value: viewModel.tipoSeleccionado?.id,
                      items: viewModel.tipos
                          .map((tipo) => DropdownMenuItem<int>(
                                value: tipo.id,
                                child: Text(tipo.nombre),
                              ))
                          .toList(),
                      onChanged: (id) {
                        viewModel.seleccionarTipoPorId(id);
                      },
                    ),
                  const SizedBox(height: 16),

                  // Imagen seleccionada
                  ElevatedButton.icon(
                    onPressed: viewModel.seleccionarImagen,
                    icon: const Icon(Icons.image),
                    label: const Text("Seleccionar Imagen"),
                  ),
                  const SizedBox(height: 10),
                  if (viewModel.imagenSeleccionada != null)
                    ClipRRect(
                      borderRadius: BorderRadius.circular(12),
                      child: Image.file(
                        viewModel.imagenSeleccionada!,
                        height: 200,
                      ),
                    ),

                  const SizedBox(height: 16),
                  ClipRRect(
                    borderRadius: BorderRadius.circular(12),
                    child: SizedBox(
                      height: 250,
                      child: GoogleMap(
                        initialCameraPosition: CameraPosition(
                          target: viewModel.selectedLocation,
                          zoom: 15,
                        ),
                        onTap: viewModel.actualizarUbicacion,
                        markers: {
                          Marker(
                            markerId: const MarkerId('selectedLocation'),
                            position: viewModel.selectedLocation,
                            infoWindow: const InfoWindow(
                              title: 'Ubicación seleccionada',
                            ),
                          ),
                        },
                        zoomControlsEnabled: true,
                      ),
                    ),
                  ),
                  const SizedBox(height: 24),
                  SizedBox(
                    width: double.infinity,
                    child: ElevatedButton.icon(
                      icon: const Icon(Icons.send),
                      label: const Text('Enviar'),
                      onPressed: viewModel.isLoading
                          ? null
                          : () async {
                              final response = await viewModel.enviarReporte(ciudadanoId);

                              if (!context.mounted) return;

                              if (response['success'] == true) {
                                ScaffoldMessenger.of(context).showSnackBar(
                                  const SnackBar(content: Text('Incidencia enviada')),
                                );
                              } else {
                                ScaffoldMessenger.of(context).showSnackBar(
                                  SnackBar(
                                    content: Text(
                                      'Error: ${response['message']}',
                                    ),
                                  ),
                                );
                              }
                            },
                      style: ElevatedButton.styleFrom(
                        backgroundColor: Colors.teal,
                        padding: const EdgeInsets.symmetric(vertical: 16),
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(30),
                        ),
                        textStyle: const TextStyle(fontSize: 18),
                      ),
                    ),
                  ),
                ],
              ),
            );
          },
        ),
      ),
    );
  }
}
