import 'package:flutter/material.dart';
import '../services/auth_service.dart';
import 'login_screen.dart';

class RegisterScreen extends StatefulWidget {
  @override
  _RegisterScreenState createState() => _RegisterScreenState();
}

class _RegisterScreenState extends State<RegisterScreen> {
  final _formKey = GlobalKey<FormState>();
  String dni = ''; // Nuevo campo para DNI
  String name = '';
  String surname = ''; // Cambié el nombre de 'apellido' a 'surname' para más claridad
  String email = '';
  String password = '';
  bool isLoading = false;
  String errorMessage = '';
  String successMessage = '';

  void _register() async {
    if (_formKey.currentState!.validate()) {
      setState(() {
        isLoading = true;
        errorMessage = '';
        successMessage = '';
      });
      final response = await AuthService.register(dni, name, surname, email, password);
      setState(() {
        isLoading = false;
      });
      if (response['success'] == true) {
        setState(() {
          successMessage = response['message'];
        });
      } else {
        setState(() {
          errorMessage = response['message'] ?? 'Error desconocido';
        });
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Registro')),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Form(
          key: _formKey,
          child: SingleChildScrollView(
            child: Column(
              children: [
                if (errorMessage.isNotEmpty)
                  Text(errorMessage, style: const TextStyle(color: Colors.red)),
                if (successMessage.isNotEmpty)
                  Text(successMessage, style: const TextStyle(color: Colors.green)),
                TextFormField(
                  decoration: const InputDecoration(labelText: 'DNI'),
                  validator: (value) {
                    if (value == null || value.isEmpty) {
                      return 'Por favor ingrese su DNI';
                    }
                    return null;
                  },
                  onChanged: (value) => dni = value,
                ),
                TextFormField(
                  decoration: const InputDecoration(labelText: 'Nombre'),
                  validator: (value) {
                    if (value == null || value.isEmpty) {
                      return 'Por favor ingrese su nombre';
                    }
                    return null;
                  },
                  onChanged: (value) => name = value,
                ),
                TextFormField(
                  decoration: const InputDecoration(labelText: 'Apellido'),
                  validator: (value) {
                    if (value == null || value.isEmpty) {
                      return 'Por favor ingrese su apellido';
                    }
                    return null;
                  },
                  onChanged: (value) => surname = value,
                ),
                TextFormField(
                  decoration: const InputDecoration(labelText: 'Correo'),
                  keyboardType: TextInputType.emailAddress,
                  validator: (value) {
                    if (value == null || value.isEmpty) {
                      return 'Por favor ingrese su correo';
                    }
                    if (!RegExp(r'^[^@]+@[^@]+\.[^@]+').hasMatch(value)) {
                      return 'Ingrese un correo válido';
                    }
                    return null;
                  },
                  onChanged: (value) => email = value,
                ),
                TextFormField(
                  decoration: const InputDecoration(labelText: 'Contraseña'),
                  obscureText: true,
                  validator: (value) {
                    if (value == null || value.isEmpty) {
                      return 'Por favor ingrese su contraseña';
                    }
                    if (value.length < 8) {
                      return 'La contraseña debe tener al menos 8 caracteres';
                    }
                    return null;
                  },
                  onChanged: (value) => password = value,
                ),
                const SizedBox(height: 20),
                isLoading
                    ? const CircularProgressIndicator()
                    : ElevatedButton(
                        onPressed: _register,
                        child: const Text('Registrarse'),
                      ),
                TextButton(
                  onPressed: () {
                    Navigator.pop(context);
                  },
                  child: const Text('¿Ya tienes cuenta? Inicia sesión'),
                )
              ],
            ),
          ),
        ),
      ),
    );
  }
}
