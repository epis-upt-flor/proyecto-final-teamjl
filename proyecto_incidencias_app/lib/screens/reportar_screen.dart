import 'dart:io';
import 'package:flutter/material.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';
import 'package:geocoding/geocoding.dart';
import 'package:image_picker/image_picker.dart';
import '../services/incidencia_service.dart';

class ReportarScreen extends StatefulWidget {
  final int ciudadanoId;

  const ReportarScreen({Key? key, required this.ciudadanoId}) : super(key: key);

  @override
  State<ReportarScreen> createState() => _ReportarScreenState();
}

class _ReportarScreenState extends State<ReportarScreen> {
  final TextEditingController _descripcionController = TextEditingController();
  final TextEditingController _direccionController = TextEditingController();
  final TextEditingController _zonaController = TextEditingController();
  late GoogleMapController _mapController;

  LatLng _selectedLocation = const LatLng(-18.03727, -70.25357);
  List<Map<String, dynamic>> _tipos = [];
  int? _tipoSeleccionadoId;
  File? _imagenSeleccionada;

  static const LatLng _centroGregorio = LatLng(-18.03727, -70.25357);

  @override
  void initState() {
    super.initState();
    _cargarTipos();
  }

  Future<void> _cargarTipos() async {
    final tipos = await IncidenciaService.obtenerTiposIncidencia();
    setState(() {
      _tipos = tipos;
      if (_tipos.isNotEmpty) {
        _tipoSeleccionadoId = _tipos[0]['id'];
      }
    });
  }

  Future<void> _seleccionarImagen() async {
    final picker = ImagePicker();
    final pickedFile = await picker.pickImage(source: ImageSource.gallery);
    if (pickedFile != null) {
      setState(() {
        _imagenSeleccionada = File(pickedFile.path);
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Reportar Incidencia'),
        backgroundColor: Colors.teal,
      ),
      body: SingleChildScrollView(
        child: Padding(
          padding: const EdgeInsets.all(20),
          child: Column(
            children: [
              TextField(
                controller: _descripcionController,
                decoration: const InputDecoration(
                  labelText: 'Descripción',
                  border: OutlineInputBorder(),
                ),
                maxLines: 3,
              ),
              const SizedBox(height: 16),
              TextField(
                controller: _direccionController,
                decoration: const InputDecoration(
                  labelText: 'Dirección',
                  border: OutlineInputBorder(),
                ),
              ),
              const SizedBox(height: 16),
              TextField(
                controller: _zonaController,
                decoration: const InputDecoration(
                  labelText: 'Zona',
                  border: OutlineInputBorder(),
                ),
              ),
              const SizedBox(height: 16),

              // Selección del tipo de incidencia restaurado
              if (_tipos.isNotEmpty)
                DropdownButton<int>(
                  value: _tipoSeleccionadoId,
                  items: _tipos.map((tipo) {
                    return DropdownMenuItem<int>(
                      value: tipo['id'],
                      child: Text(tipo['nombre']),
                    );
                  }).toList(),
                  onChanged: (int? newValue) {
                    setState(() {
                      _tipoSeleccionadoId = newValue!;
                    });
                  },
                ),
              const SizedBox(height: 16),

              // Botón para seleccionar imagen
              ElevatedButton.icon(
                onPressed: _seleccionarImagen,
                icon: const Icon(Icons.image),
                label: const Text("Seleccionar Imagen"),
              ),
              const SizedBox(height: 10),
              if (_imagenSeleccionada != null)
                ClipRRect(
                  borderRadius: BorderRadius.circular(12),
                  child: Image.file(
                    _imagenSeleccionada!,
                    height: 200,
                  ),
                ),

              const SizedBox(height: 16),
              ClipRRect(
                borderRadius: BorderRadius.circular(12),
                child: SizedBox(
                  height: 250,
                  child: GoogleMap(
                    initialCameraPosition: const CameraPosition(
                      target: _centroGregorio,
                      zoom: 15,
                    ),
                    onMapCreated: (controller) {
                      _mapController = controller;
                    },
                    onTap: (LatLng location) {
                      setState(() {
                        _selectedLocation = location;
                      });
                      _geocodeLocation(location);
                    },
                    markers: {
                      Marker(
                        markerId: const MarkerId('selectedLocation'),
                        position: _selectedLocation,
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
                  onPressed: () async {
                    if (_tipoSeleccionadoId == null) return;

                    final response = await IncidenciaService.registrarIncidenciaConFoto(
                      descripcion: _descripcionController.text,
                      latitud: _selectedLocation.latitude,
                      longitud: _selectedLocation.longitude,
                      direccion: _direccionController.text,
                      zona: _zonaController.text,
                      tipoId: _tipoSeleccionadoId!,
                      foto: _imagenSeleccionada,
                      ciudadanoId: widget.ciudadanoId,
                    );

                    if (response['success'] == true) {
                      ScaffoldMessenger.of(context).showSnackBar(
                        const SnackBar(content: Text('Incidencia enviada')),
                      );
                    } else {
                      ScaffoldMessenger.of(context).showSnackBar(
                        SnackBar(content: Text('Error: ${response['message']}')),
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
        ),
      ),
    );
  }

  void _geocodeLocation(LatLng location) async {
    try {
      List<Placemark> placemarks = await placemarkFromCoordinates(location.latitude, location.longitude);
      if (placemarks.isNotEmpty) {
        Placemark place = placemarks[0];
        setState(() {
          _direccionController.text = '${place.name}, ${place.street}, ${place.locality}, ${place.country}';
          _zonaController.text = place.subAdministrativeArea ?? "Zona no disponible";
        });
      }
    } catch (e) {
      print("Error al obtener la dirección: $e");
    }
  }
}
