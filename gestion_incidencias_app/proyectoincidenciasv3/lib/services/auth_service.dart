// lib/services/auth_service.dart
import 'dart:convert';
import 'package:http/http.dart' as http;
import '../config.dart';

class AuthService {
  // Método para iniciar sesión (usuarios y empleados)
  static Future<Map<String, dynamic>> login(String email, String password) async {
  final url = Uri.parse('$BASE_URL/api/login.php');
  try {
    final response = await http.post(url, body: {
      'correo': email,
      'password': password, // 🔹 Cambié 'contraseña' por 'password'
    });

    if (response.statusCode == 200) {
      return json.decode(response.body);
    } else {
      return {'success': false, 'message': 'Error en el servidor'};
    }
  } catch (e) {
    return {'success': false, 'message': e.toString()};
  }
}

  // Método para registrar un nuevo usuario (ciudadano o empleado)
  static Future<Map<String, dynamic>> register(String name, String email, String password, String role) async {
    final url = Uri.parse('$BASE_URL/api/register.php');
    try {
      final response = await http.post(url, body: {
        'nombre': name,
        'correo': email,
        'password': password, // 🔹 Ahora está correcto
        'rol': role,  // 'ciudadano' o 'empleado'
      });

      if (response.statusCode == 200) {
        return json.decode(response.body);
      } else {
        return {'success': false, 'message': 'Error en el servidor'};
      }
    } catch (e) {
      return {'success': false, 'message': e.toString()};
    }
  }
}
