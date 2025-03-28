import 'package:flutter/material.dart';
import 'ver_mapa_screen.dart';
import '../main.dart'; // Importado para poder usar WelcomeScreen

class CiudadanoScreen extends StatelessWidget {
  final Map<String, dynamic> user;

  const CiudadanoScreen({Key? key, required this.user}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Container(
        decoration: const BoxDecoration(
          gradient: LinearGradient(
            colors: [Color(0xFF2193b0), Color(0xFF6dd5ed)],
            begin: Alignment.topLeft,
            end: Alignment.bottomRight,
          ),
        ),
        child: SafeArea(
          child: Padding(
            padding: const EdgeInsets.all(20),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                const Text(
                  'Bienvenido',
                  style: TextStyle(
                    fontSize: 26,
                    fontWeight: FontWeight.bold,
                    color: Colors.white,
                  ),
                ),
                const SizedBox(height: 12),
                const Text(
                  'Selecciona una opción:',
                  style: TextStyle(
                    fontSize: 16,
                    color: Colors.white70,
                  ),
                ),
                const SizedBox(height: 20),
                Expanded(
                  child: GridView.count(
                    crossAxisCount: 2,
                    crossAxisSpacing: 16,
                    mainAxisSpacing: 16,
                    children: [
                      _buildOption(context, Icons.report, 'Reportar\nIncidencia', Container()),
                      _buildOption(context, Icons.map, 'Ver\nMapa', const VerMapaScreen()),
                      _buildOption(context, Icons.history, 'Mi\nHistorial', Container()),
                      _buildOption(context, Icons.notifications, 'Notificaciones', Container()),
                      _buildOption(context, Icons.person, 'Mi\nPerfil', Container()),
                      _buildOption(context, Icons.logout, 'Salir', null), // Salir
                    ],
                  ),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildOption(BuildContext context, IconData icon, String label, Widget? screen) {
    return Card(
      color: Colors.white.withOpacity(0.9),
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(20)),
      elevation: 6,
      child: InkWell(
        onTap: () {
          if (label == 'Salir') {
            Navigator.pushAndRemoveUntil(
              context,
              MaterialPageRoute(builder: (context) => const WelcomeScreen()),
              (route) => false,
            );
          } else {
            Navigator.push(
              context,
              MaterialPageRoute(builder: (context) => screen!),
            );
          }
        },
        borderRadius: BorderRadius.circular(20),
        child: Center(
          child: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              Icon(icon, size: 42, color: Colors.blue),
              const SizedBox(height: 10),
              Text(
                label,
                textAlign: TextAlign.center,
                style: const TextStyle(
                  fontSize: 14,
                  fontWeight: FontWeight.w600,
                  color: Colors.black87,
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
