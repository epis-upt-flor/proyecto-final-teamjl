import 'package:flutter/material.dart';
import '../services/incidencia_service.dart';
import 'ciudadano_home.dart';

class PhoneInputScreen extends StatefulWidget {
  const PhoneInputScreen({Key? key}) : super(key: key);

  @override
  State<PhoneInputScreen> createState() => _PhoneInputScreenState();
}

class _PhoneInputScreenState extends State<PhoneInputScreen> {
  final TextEditingController _phoneController = TextEditingController();
  bool _isLoading = false;

  Future<void> _continuar() async {
    String celular = _phoneController.text.trim();
    if (celular.isEmpty || celular.length < 9) {
      _mostrarMensaje('Por favor ingrese un número de teléfono válido.');
      return;
    }

    setState(() {
      _isLoading = true;
    });

    try {
      final response = await IncidenciaService.validarTelefono(celular);

      if (response != null && response['success'] == true) {
        int idCelular = response['data']['id'] ?? 0;
        Navigator.pushReplacement(
          context,
          MaterialPageRoute(
            builder: (context) => CiudadanoHome(user: {'id_celular': idCelular}),
          ),
        );
      } else {
        String errorMessage = response?['message'] ?? 'Error desconocido';
        _mostrarMensaje(errorMessage);
      }
    } catch (e) {
      _mostrarMensaje('Error al verificar el teléfono.');
    } finally {
      setState(() {
        _isLoading = false;
      });
    }
  }

  void _mostrarMensaje(String mensaje) {
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(content: Text(mensaje)),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Ingreso de Teléfono'),
        backgroundColor: Colors.teal,
      ),
      body: Padding(
        padding: const EdgeInsets.all(20),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            const Text(
              'Ingrese su número de teléfono',
              style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
            ),
            const SizedBox(height: 20),
            TextField(
              controller: _phoneController,
              keyboardType: TextInputType.phone,
              decoration: const InputDecoration(
                labelText: 'Teléfono',
                border: OutlineInputBorder(),
                prefixIcon: Icon(Icons.phone),
              ),
            ),
            const SizedBox(height: 20),
            SizedBox(
              width: double.infinity,
              child: ElevatedButton(
                onPressed: _isLoading ? null : _continuar,
                style: ElevatedButton.styleFrom(
                  backgroundColor: Colors.teal,
                  padding: const EdgeInsets.symmetric(vertical: 14),
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(30),
                  ),
                ),
                child: _isLoading
                    ? const CircularProgressIndicator(color: Colors.white)
                    : const Text(
                        'Continuar',
                        style: TextStyle(fontSize: 18),
                      ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}
