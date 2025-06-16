import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../viewmodels/register_viewmodel.dart';

class RegisterScreen extends StatelessWidget {
  RegisterScreen({super.key});

  final _formKey = GlobalKey<FormState>();

  @override
  Widget build(BuildContext context) {
    return ChangeNotifierProvider<RegisterViewModel>(
      create: (_) => RegisterViewModel(),
      child: Scaffold(
        appBar: AppBar(title: const Text('Registro')),
        body: Consumer<RegisterViewModel>(
          builder: (context, viewModel, child) {
            return Padding(
              padding: const EdgeInsets.all(16.0),
              child: Form(
                key: _formKey,
                child: SingleChildScrollView(
                  child: Column(
                    children: [
                      if (viewModel.errorMessage != null)
                        Text(viewModel.errorMessage!, style: const TextStyle(color: Colors.red)),
                      if (viewModel.successMessage != null)
                        Text(viewModel.successMessage!, style: const TextStyle(color: Colors.green)),
                      TextFormField(
                        decoration: const InputDecoration(labelText: 'DNI'),
                        validator: (value) {
                          if (value == null || value.isEmpty) {
                            return 'Por favor ingrese su DNI';
                          }
                          return null;
                        },
                        onChanged: viewModel.setDni,
                      ),
                      TextFormField(
                        decoration: const InputDecoration(labelText: 'Nombre'),
                        validator: (value) {
                          if (value == null || value.isEmpty) {
                            return 'Por favor ingrese su nombre';
                          }
                          return null;
                        },
                        onChanged: viewModel.setNombre,
                      ),
                      TextFormField(
                        decoration: const InputDecoration(labelText: 'Apellido'),
                        validator: (value) {
                          if (value == null || value.isEmpty) {
                            return 'Por favor ingrese su apellido';
                          }
                          return null;
                        },
                        onChanged: viewModel.setApellido,
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
                        onChanged: viewModel.setCorreo,
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
                        onChanged: viewModel.setPassword,
                      ),
                      const SizedBox(height: 20),
                      viewModel.isLoading
                          ? const CircularProgressIndicator()
                          : ElevatedButton(
                              onPressed: () async {
                                if (_formKey.currentState!.validate()) {
                                  await viewModel.registrar();
                                }
                              },
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
            );
          },
        ),
      ),
    );
  }
}
