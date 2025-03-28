// lib/services/auth_service.dart
import 'dart:convert';
import 'package:http/http.dart' as http;
import '../config.dart';

class AuthService {
  // Método para iniciar sesión (empleados)
  static Future<Map<String, dynamic>> login(String email, String password) async {
    final url = Uri.parse('$BASE_URL/api/api_empleados/login.php'); // Corregido aquí
    try {
      print('Datos de login enviados: correo=$email, password=$password'); // Imprimir datos enviados
      final response = await http.post(url, body: {
        'email': email,
        'password': password,
      });

      print('Respuesta del servidor: ${response.body}'); // Imprimir respuesta del servidor

      if (response.statusCode == 200) {
        return json.decode(response.body);
      } else {
        return {'success': false, 'message': 'Error en el servidor'};
      }
    } catch (e) {
      return {'success': false, 'message': e.toString()};
    }
  }

  // Método para registrar un nuevo empleado
  static Future<Map<String, dynamic>> register(String dni, String name, String surname, String email, String password) async {
    final url = Uri.parse('$BASE_URL/api/api_empleados/register.php'); // Endpoint corregido para el registro de empleados
    try {
      print('Datos de registro enviados: dni=$dni, nombre=$name, apellido=$surname, correo=$email, password=$password'); // Imprimir datos enviados
      final response = await http.post(url, body: {
        'dni': dni,
        'nombre': name,
        'apellido': surname,
        'email': email,
        'password': password, // Contraseña para el registro
      });

      print('Respuesta del servidor: ${response.body}'); // Imprimir respuesta del servidor

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
