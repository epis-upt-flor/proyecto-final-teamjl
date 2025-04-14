import 'dart:convert';
import 'package:http/http.dart' as http;
import '../config.dart';

class AuthService {
  static Future<Map<String, dynamic>> login(String email, String password) async {
    final url = Uri.parse('${BASE_URL}api_empleados/login.php');

    try {
      print('Intentando iniciar sesión con: $email');

      final response = await http.post(
        url,
        headers: {'Content-Type': 'application/json'},
        body: jsonEncode({'email': email, 'password': password}),
      );

      print('Respuesta: ${response.body}');

      if (response.statusCode == 200) {
        final responseData = jsonDecode(response.body);
        return responseData;
      } else {
        return {'success': false, 'message': 'Error del servidor'};
      }
    } catch (e) {
      return {'success': false, 'message': 'Excepción: $e'};
    }
  }

  static Future<Map<String, dynamic>> register(String dni, String name, String surname, String email, String password) async {
    final url = Uri.parse('${BASE_URL}api_empleados/registrar.php');

    try {
      print('Intentando registrar a: $dni $name $surname');

      final response = await http.post(
        url,
        headers: {'Content-Type': 'application/json'},
        body: jsonEncode({
          'dni': dni,
          'nombre': name,
          'apellido': surname,
          'email': email,
          'password': password,
        }),
      );

      print('Respuesta: ${response.body}');

      if (response.statusCode == 200) {
        final responseData = jsonDecode(response.body);
        return responseData;
      } else {
        return {'success': false, 'message': 'Error del servidor'};
      }
    } catch (e) {
      return {'success': false, 'message': 'Excepción: $e'};
    }
  }
}
