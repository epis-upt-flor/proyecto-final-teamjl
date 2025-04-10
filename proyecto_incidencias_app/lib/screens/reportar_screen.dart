import 'package:flutter/material.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';
import 'package:geocoding/geocoding.dart';
import '../services/incidencia_service.dart';

class ReportarScreen extends StatefulWidget {
  const ReportarScreen({Key? key}) : super(key: key);

  @override
  State<ReportarScreen> createState() => _ReportarScreenState();
}

class _ReportarScreenState extends State<ReportarScreen> {
  final TextEditingController _descripcionController = TextEditingController();
  final TextEditingController _direccionController = TextEditingController();
  final TextEditingController _zonaController = TextEditingController();
  late GoogleMapController _mapController;

  // Ubicación predeterminada
  LatLng _selectedLocation = LatLng(-18.03727, -70.25357);


  final List<String> _tipos = [
    "Fugas de agua",
    "Daños en la vía pública",
    "Problemas con la iluminación",
    "Basura y desechos",
    "Problemas de señalización",
    "Árboles caídos",
    "Daños en edificios públicos",
    "Accidentes de tráfico",
    "Drenaje obstruido",
    "Otros"
  ];

  String _tipoSeleccionado = "Fugas de agua";

  static const LatLng _centroGregorio = LatLng(-18.03727, -70.25357);

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
              // Descripcion
              TextField(
                controller: _descripcionController,
                decoration: const InputDecoration(
                  labelText: 'Descripción',
                  border: OutlineInputBorder(),
                ),
                maxLines: 3,
              ),
              const SizedBox(height: 16),

              // Direccion
              TextField(
                controller: _direccionController,
                decoration: const InputDecoration(
                  labelText: 'Dirección',
                  border: OutlineInputBorder(),
                ),
              ),
              const SizedBox(height: 16),

              // Zona
              TextField(
                controller: _zonaController,
                decoration: const InputDecoration(
                  labelText: 'Zona',
                  border: OutlineInputBorder(),
                ),
              ),
              const SizedBox(height: 16),

              // Seleccionar tipo
              DropdownButton<String>(
                value: _tipoSeleccionado,
                items: _tipos.map((String tipo) {
                  return DropdownMenuItem<String>(
                    value: tipo,
                    child: Text(tipo),
                  );
                }).toList(),
                onChanged: (String? newValue) {
                  setState(() {
                    _tipoSeleccionado = newValue!;
                  });
                },
              ),
              const SizedBox(height: 16),

              // Mapa
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

              // Botón de Enviar
              SizedBox(
                width: double.infinity,
                child: ElevatedButton.icon(
                  icon: const Icon(Icons.send),
                  label: const Text('Enviar'),
                  onPressed: () async {
                    final response = await IncidenciaService.registrarIncidencia(
                      _descripcionController.text,
                      _selectedLocation.latitude,
                      _selectedLocation.longitude,
                      _direccionController.text,
                      _zonaController.text,
                      _tipoSeleccionado,
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
