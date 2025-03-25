import 'package:flutter/material.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';

class VerMapaScreen extends StatefulWidget {
  const VerMapaScreen({Key? key}) : super(key: key);

  @override
  State<VerMapaScreen> createState() => _VerMapaScreenState();
}

class _VerMapaScreenState extends State<VerMapaScreen> {
  static const LatLng _centroGregorio = LatLng(-18.03727, -70.25357);
  late GoogleMapController _mapController;

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Mapa de Incidencias'),
      ),
      body: GoogleMap(
        initialCameraPosition: const CameraPosition(
          target: _centroGregorio,
          zoom: 15,
        ),
        onMapCreated: (controller) {
          _mapController = controller;
        },
        myLocationEnabled: true,
        zoomControlsEnabled: true,
        markers: {
          Marker(
            markerId: const MarkerId('centro'),
            position: _centroGregorio,
            infoWindow: const InfoWindow(
              title: 'Gregorio Albarracín',
              snippet: 'Zona central',
            ),
          )
        },
      ),
    );
  }
}
