import 'package:flutter/material.dart';
import 'reportar_screen.dart';
import 'historial_screen.dart';

class CiudadanoHome extends StatefulWidget {
  final Map<String, dynamic> user;

  const CiudadanoHome({super.key, required this.user});

  @override
  State<CiudadanoHome> createState() => _CiudadanoHomeState();
}

class _CiudadanoHomeState extends State<CiudadanoHome> {
  int _selectedIndex = 0;

  void _onItemTapped(int index) {
    setState(() {
      _selectedIndex = index;
    });
  }

  @override
  Widget build(BuildContext context) {
    final List<Widget> screens = <Widget>[
      ReportarScreen(ciudadanoId: widget.user['id_celular']),
      HistorialScreen(ciudadanoId: widget.user['id_celular']),
      const Center(child: Text('Notificaciones')),
      const Center(child: Text('Perfil')),
    ];

    return Scaffold(
      body: screens[_selectedIndex],
      bottomNavigationBar: BottomNavigationBar(
        backgroundColor: Colors.white,
        selectedItemColor: Colors.teal,
        unselectedItemColor: Colors.grey,
        showUnselectedLabels: true,
        currentIndex: _selectedIndex,
        onTap: _onItemTapped,
        type: BottomNavigationBarType.fixed,
        items: const [
          BottomNavigationBarItem(
            icon: Icon(Icons.add_location_alt_outlined),
            label: 'Reportar',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.history),
            label: 'Historial',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.notifications_none),
            label: 'Notificaciones',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.person_outline),
            label: 'Perfil',
          ),
        ],
      ),
    );
  }
}
