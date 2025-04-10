import 'dart:convert';
import 'package:http/http.dart' as http;
import '../config.dart';

class IncidenciaService {
  static Future<Map<String, dynamic>> registrarIncidencia(
    String descripcion,
    double latitud,
    double longitud,
    String direccion,
    String zona,
    String tipo,
  ) async {
    final url = Uri.parse('${BASE_URL}api_ciudadano/registrar_incidencia.php');

    try {
      final response = await http.post(
        url,
        headers: {'Content-Type': 'application/json'},
        body: jsonEncode({
          'descripcion': descripcion,
          'latitud': latitud,
          'longitud': longitud,
          'direccion': direccion,
          'zona': zona,
          'tipo': tipo,
        }),
      );

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
