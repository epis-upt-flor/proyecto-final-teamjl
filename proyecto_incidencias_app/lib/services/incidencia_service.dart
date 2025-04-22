import 'dart:convert';
import 'dart:io';
import 'package:http/http.dart' as http;
import 'package:http_parser/http_parser.dart';
import '../config.dart';

class IncidenciaService {
  // Registrar incidencia con imagen (multipart/form-data)
  static Future<Map<String, dynamic>> registrarIncidenciaConFoto({
    required String descripcion,
    required double latitud,
    required double longitud,
    required String direccion,
    required String zona,
    required int tipoId,
    File? foto,
  }) async {
    final url = Uri.parse('${BASE_URL}api_ciudadano/registrar_incidencia.php');

    try {
      var request = http.MultipartRequest('POST', url);

      // Campos normales
      request.fields['descripcion'] = descripcion;
      request.fields['latitud'] = latitud.toString();
      request.fields['longitud'] = longitud.toString();
      request.fields['direccion'] = direccion;
      request.fields['zona'] = zona;
      request.fields['tipo_id'] = tipoId.toString();

      // Si hay foto, la añadimos como archivo
      if (foto != null) {
        request.files.add(
          await http.MultipartFile.fromPath(
            'foto',
            foto.path,
            contentType: MediaType('image', 'jpeg'), // puedes cambiar si no es JPG
          ),
        );
      }

      final streamedResponse = await request.send();
      final response = await http.Response.fromStream(streamedResponse);

      if (response.statusCode == 200) {
        return jsonDecode(response.body);
      } else {
        return {'success': false, 'message': 'Error del servidor'};
      }
    } catch (e) {
      return {'success': false, 'message': 'Excepción: $e'};
    }
  }

  // Obtener lista de tipos de incidencia
  static Future<List<Map<String, dynamic>>> obtenerTiposIncidencia() async {
    final url = Uri.parse('${BASE_URL}api_ciudadano/tipos_incidencia.php');

    try {
      final response = await http.get(url);

      if (response.statusCode == 200) {
        final List<dynamic> data = jsonDecode(response.body);
        return data.map((item) => {
          'id': item['id'],
          'nombre': item['nombre'],
        }).toList();
      } else {
        return [];
      }
    } catch (e) {
      return [];
    }
  }
}
