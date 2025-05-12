import 'dart:convert';
import 'dart:typed_data';
import 'package:http/http.dart' as http;
import '../config.dart';

class IncidenciasEmpleadoService {
  // Obtener incidencias asignadas a un empleado
  static Future<List<Map<String, dynamic>>> obtenerIncidenciasAsignadas(int empleadoId) async {
    final url = Uri.parse('${BASE_URL}api_empleados/incidencias_asignadas.php?empleado_id=$empleadoId');

    try {
      final response = await http.get(url);

      if (response.statusCode == 200) {
        final responseData = jsonDecode(response.body);
        if (responseData['success'] == true && responseData['data'] is List) {
          List<Map<String, dynamic>> incidencias = List<Map<String, dynamic>>.from(responseData['data']);
          for (var incidencia in incidencias) {
            // Verificar si contiene la foto y decodificarla
            if (incidencia.containsKey('foto') && incidencia['foto'] != null) {
              try {
                // Decodificar la imagen desde base64 a Uint8List
                Uint8List fotoBytes = base64Decode(incidencia['foto']);
                incidencia['foto'] = fotoBytes;
                print("Foto procesada correctamente: ${incidencia['id']}");
              } catch (e) {
                print("Error al decodificar la foto: $e");
                incidencia['foto'] = null;
              }
            }
          }
          return incidencias;
        } else {
          print("Error en la estructura de datos recibidos: ${responseData['message']}");
          return [];
        }
      } else {
        print("Error en la solicitud: Código ${response.statusCode}");
        return [];
      }
    } catch (e) {
      print("Error al obtener incidencias: $e");
      return [];
    }
  }

  // Actualizar el estado de una incidencia
  static Future<bool> actualizarEstado(int incidenciaId, int nuevoEstadoId) async {
    final url = Uri.parse('${BASE_URL}api_empleados/actualizar_estado.php');

    try {
      final response = await http.post(
        url,
        headers: {'Content-Type': 'application/json'},
        body: jsonEncode({
          'incidencia_id': incidenciaId,
          'nuevo_estado': nuevoEstadoId,
        }),
      );

      if (response.statusCode == 200) {
        final responseData = jsonDecode(response.body);
        return responseData['success'] == true;
      } else {
        print("Error al actualizar estado: Código ${response.statusCode}");
        return false;
      }
    } catch (e) {
      print("Error al actualizar estado: $e");
      return false;
    }
  }

  // Obtener los detalles de una incidencia específica
  static Future<Map<String, dynamic>?> obtenerIncidenciaPorId(int empleadoId, int incidenciaId) async {
    final url = Uri.parse('${BASE_URL}api_empleados/incidencias_asignadas.php?empleado_id=$empleadoId');

    try {
      final response = await http.get(url);

      if (response.statusCode == 200) {
        final responseData = jsonDecode(response.body);
        if (responseData['success'] == true && responseData['data'] is List) {
          var incidencia = List<Map<String, dynamic>>.from(responseData['data'])
              .firstWhere((element) => element['id'] == incidenciaId, orElse: () => {});
          
          // Verificar si contiene la foto y decodificarla
          if (incidencia.containsKey('foto') && incidencia['foto'] != null) {
            try {
              // Decodificar la imagen desde base64 a Uint8List
              Uint8List fotoBytes = base64Decode(incidencia['foto']);
              incidencia['foto'] = fotoBytes;
              print("Foto de incidencia procesada: ${incidencia['id']}");
            } catch (e) {
              print("Error al decodificar la foto: $e");
              incidencia['foto'] = null;
            }
          }
          return incidencia;
        } else {
          print("Error en la estructura de datos recibidos: ${responseData['message']}");
          return null;
        }
      } else {
        print("Error en la solicitud: Código ${response.statusCode}");
        return null;
      }
    } catch (e) {
      print("Error al obtener detalle de incidencia: $e");
      return null;
    }
  }
}
