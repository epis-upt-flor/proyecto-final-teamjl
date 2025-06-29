
# 🛠️ Sistema Web de gestión de incidentes en infraestructuras basado en Crowdsourcing para el distrito Gregorio Albarracín Lanchipa

### INTEGRANTES:

Castañeda Centurión, Jorge Enrique (2021069822)

Hurtado Ortiz, Leandro (2015052384)

---
Este proyecto permite a los ciudadanos reportar incidencias urbanas desde una aplicación móvil desarrollada en Flutter, mientras que los administradores y empleados gestionan estos reportes desde un panel web desarrollado en PHP. El sistema está integrado con una base de datos PostgreSQL y cuenta con autenticación JWT y arquitectura desacoplada (MVC + Service Layer + API REST).

---

## 📱 Aplicación Flutter (Ciudadano y Empleado)

### Funcionalidades:
- 📍 Reporte de incidencias con ubicación GPS
- 📷 Adjuntar imagen desde cámara o galería
- 📑 Visualización del historial por número de celular
- 🔒 Inicio de sesión para empleados
- 📋 Visualización de tareas asignadas
- 🔄 Actualización de estado de incidencias

### Capturas:
![Reporte de incidencia](assets/screenshots/app_ciudadano.png)
![Tareas asignadas al empleado](assets/screenshots/app_empleado.png)

---

## 🌐 Panel Web PHP (Administrador)

### Funcionalidades:
- 🔐 Login seguro con JWT
- 📊 Dashboard de incidencias filtradas por estado
- 🧑‍💼 Asignación de empleados a tareas
- 📅 Programación de fechas de resolución (calendario)
- 📄 Generación de reportes PDF
- 📈 Visualización de estadísticas con gráficos

### Capturas:
![Dashboard de incidencias](assets/screenshots/web_dashboard.png)
![Formulario de asignación](assets/screenshots/web_asignacion.png)

---

## 🧩 Estructura del Proyecto
## Web PHP
### Frotend:
```
admin/
│
├── controllers/
│   ├── AuthController.php
│   ├── DashboardController.php
│   ├── EmpleadosController.php
│   ├── IncidenciasController.php
│   └── ReporteController.php
│
├── middleware/
│   └── protect.php
│
├── reporte/
│   ├── fpdf/
│   ├── debug_dataGrp.json
│   ├── debug_error.txt
│   ├── generar_excel.php
│   └── generar_pdf.php
│
├── views/
│   ├── auth/
│   │   ├── layout.php
│   │   ├── login.php
│   │   └── register.php
│   ├── partials/
│   │   ├── footer.php
│   │   ├── header.php
│   │   └── sidebar.php
│   ├── dashboard.php
│   ├── empleados.php
│   ├── incidencias.php
│   ├── layout.php
│   └── reporte.php
│
├── config.php
├── helpers.php
└── index.php

```

### Backend:
```
api/
│
├── public/
│   ├── admin_dashboard/
│   │   ├── asignar_incidencia.php
│   │   ├── empleados.php
│   │   ├── incidencias.php
│   │   ├── incidencias_por_empleado.php
│   │   ├── prioridad.php
│   │   ├── programar_fecha.php
│   │   ├── reporte_csv.php
│   │   ├── resumen_estadistico.php
│   │   ├── resumen_incidencias.php
│   │   └── tipos_incidencia.php
│   │
│   ├── api_ciudadano/
│   │   ├── listar_incidencias.php
│   │   ├── registrar_incidencia.php
│   │   ├── tipos_incidencia.php
│   │   ├── upload.php
│   │   └── validar_telefono.php
│   │
│   ├── api_empleados/
│   │   ├── actualizar_estado.php
│   │   ├── incidencias_asignadas.php
│   │
│   ├── login.php
│   ├── register.php
│   └── .htaccess
│
├── src/
│   ├── Controllers/
│   │   ├── AdminController.php
│   │   ├── CiudadanoController.php
│   │   ├── EmpleadoController.php
│   │   ├── IncidenciaController.php
│   │   ├── PrioridadController.php
│   │   └── ReporteController.php
│   │
│   ├── Core/
│   │   ├── Auth.php
│   │   ├── Database.php
│   │   └── Response.php
│   │
│   ├── Repositories/
│   │   ├── AdminRepository.php
│   │   ├── CalendarioRepository.php
│   │   ├── CiudadanoRepository.php
│   │   ├── EmpleadoRepository.php
│   │   ├── IncidenciaRepository.php
│   │   ├── PrioridadRepository.php
│   │   └── ReporteRepository.php
│   │
│   └── Services/
│       ├── AdminService.php
│       ├── CalendarioService.php
│       ├── CiudadanoService.php
│       ├── EmpleadoService.php
│       ├── IncidenciaService.php
│       ├── PrioridadService.php
│       └── ReporteService.php
│
└── bootstrap.php
```

## Flutter
Poner la estructura aquí

---

## ⚙️ Tecnologías y Herramientas

### Backend – PHP
- PHP 8+
- **Composer** 
- **PHPStan** (análisis estático de código – nivel máximo)
- JWT para autenticación
- Dotenv para variables de entorno
- PostgreSQL

### Frontend – Flutter
- Poner tecnologías y herramientas aquí

---

## 🧪 Pruebas Realizadas

| Tipo de prueba          | Herramienta         | Estado       |
|-------------------------|---------------------|--------------|
| Funcionales UI/E2E      | `flutter_test`      | ✅ Completado |
| Pruebas Unitarias       | `Apache Bench (ab)` | ✅ Completado |
| Validación de formularios | `Flutter y PHP`   | ✅ Completado |
| Análisis estático PHP   | `PHPStan nivel máximo`    | ✅ Completado |

---

## 🚀 Instrucciones de instalación

### Clonar el proyecto

```bash
git clone https://github.com/epis-upt-flor/proyecto-final-teamjl.
cd proyecto-final-teamjl
```

---

## 🗄️ Base de Datos

- PostgreSQL con las tablas:
  - `usuario` (rol: administrador, empleado)
  - `ciudadano`
  - `incidencia`
  - `calendario_incidencia`
  - `tipo_incidencia`
  - `estado`
  - `prioridad`

---

## 📌 Estado de Desarrollo

| Módulo / Requerimiento               | Estado        |
|--------------------------------------|---------------|
| RF-01 Reporte de incidencias         | ✅ Implementado |
| RF-02 Login y autenticación          | ✅ Implementado |
| RF-04 Gestión de tareas asignadas    | ✅ Implementado |
| RF-05 Dashboard administrativo       | ✅ Implementado |
| RF-07 Calendario de resolución       | ✅ Implementado |
| RF-08 Historial ciudadano            | ✅ Implementado |
| Reportes PDF y Excel                 | ✅ Implementado |
| Validación de roles y permisos       | ✅ Implementado |

---

## 📫 Contacto

Desarrollado por el equipo de desarrollo del proyecto académico.

**Correo**: jorcastaneda@upt.pe /   
**Teléfono**: +51 123-456-789  
**Sitio web**: [www.incidencias-tacna.pe](http://www.incidencias-tacna.pe)

---

## 📝 Licencia

Este proyecto es de código abierto para fines académicos y puede ser adaptado con fines educativos o gubernamentales, siempre que se dé el crédito correspondiente.