import 'dart:convert';
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
          return List<Map<String, dynamic>>.from(responseData['data']);
        } else {
          return [];
        }
      } else {
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
        return false;
      }
    } catch (e) {
      print("Error al actualizar estado: $e");
      return false;
    }
  }

  // Obtener los detalles de una incidencia específica, usando empleadoId + incidenciaId
  static Future<Map<String, dynamic>?> obtenerIncidenciaPorId(int empleadoId, int incidenciaId) async {
    final url = Uri.parse('${BASE_URL}api_empleados/incidencias_asignadas.php?empleado_id=$empleadoId');

    try {
      final response = await http.get(url);

      if (response.statusCode == 200) {
        final responseData = jsonDecode(response.body);
        if (responseData['success'] == true && responseData['data'] is List) {
          return List<Map<String, dynamic>>.from(responseData['data'])
              .firstWhere((element) => element['id'] == incidenciaId, orElse: () => {});
        } else {
          return null;
        }
      } else {
        return null;
      }
    } catch (e) {
      print("Error al obtener detalle de incidencia: $e");
      return null;
    }
  }
}
