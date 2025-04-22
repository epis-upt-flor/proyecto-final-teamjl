import 'package:flutter/material.dart';
import 'tareas_screen.dart'; // Deberás crear este archivo próximamente

class EmpleadoScreen extends StatefulWidget {
  final Map<String, dynamic> user;

  const EmpleadoScreen({Key? key, required this.user}) : super(key: key);

  @override
  State<EmpleadoScreen> createState() => _EmpleadoScreenState();
}

class _EmpleadoScreenState extends State<EmpleadoScreen> {
  int _selectedIndex = 0;

  late final List<Widget> _screens;

  @override
  void initState() {
    super.initState();
    _screens = [
      TareasScreen(user: widget.user),
      Center(child: Text('Completadas')),
      Center(child: Text('Notificaciones')),
      Center(child: Text('Perfil')),
    ];
  }

  void _onItemTapped(int index) {
    setState(() {
      _selectedIndex = index;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: _screens[_selectedIndex],
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
            icon: Icon(Icons.assignment),
            label: 'Tareas',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.check_circle),
            label: 'Completadas',
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
