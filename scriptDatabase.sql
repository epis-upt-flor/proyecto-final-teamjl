-- Database: dbGestionJL

-- DROP DATABASE IF EXISTS "dbGestionJL";

CREATE DATABASE "dbGestionJL"
    WITH
    OWNER = postgres
    ENCODING = 'UTF8'
    LC_COLLATE = 'es-PE'
    LC_CTYPE = 'es-PE'
    LOCALE_PROVIDER = 'libc'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1
    IS_TEMPLATE = False;


CREATE TABLE administradores (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    password TEXT NOT NULL,
    intentos_fallidos INT DEFAULT 0,
    ultimo_intento TIMESTAMP;
    rol VARCHAR(20) CHECK (rol IN ('admin', 'supervisor')) DEFAULT 'admin',
    fecha_registro TIMESTAMP DEFAULT NOW()
);

CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    password TEXT NOT NULL,
    rol VARCHAR(20) CHECK (rol IN ('ciudadano', 'empleado')) NOT NULL,  -- Diferenciación de roles
    confirmado BOOLEAN DEFAULT FALSE,  -- Confirmación de correo
    fecha_registro TIMESTAMP DEFAULT NOW()
);

CREATE TABLE empleados (
    id_usuario INT PRIMARY KEY REFERENCES usuarios(id) ON DELETE CASCADE,
    dni VARCHAR(20) UNIQUE NOT NULL,
    telefono VARCHAR(15),
    especialidad VARCHAR(100),
    estado VARCHAR(20) CHECK (estado IN ('activo', 'inactivo')) DEFAULT 'activo',
    latitud DECIMAL(9,6),  -- Ubicación actual
    longitud DECIMAL(9,6),
    fecha_registro TIMESTAMP DEFAULT NOW()
);

-- Tabla de Incidencias (Reportadas por Ciudadanos)
CREATE TABLE incidencias (
    id SERIAL PRIMARY KEY,
    id_usuario INT REFERENCES usuarios(id) ON DELETE CASCADE,  -- Referencia a ciudadanos
    tipo VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,
    foto TEXT NOT NULL,
    latitud DECIMAL(9,6) NOT NULL,
    longitud DECIMAL(9,6) NOT NULL,
    direccion VARCHAR(255),
    fecha_reporte TIMESTAMP DEFAULT NOW(),
    ultima_actualizacion TIMESTAMP DEFAULT NOW(),
    estado VARCHAR(20) CHECK (estado IN ('pendiente', 'validado', 'en proceso', 'resuelto', 'rechazado')) DEFAULT 'pendiente'
);

-- Tabla de Asignaciones (Tareas para Empleados, Asignadas por Administradores)
CREATE TABLE asignaciones (
    id SERIAL PRIMARY KEY,
    id_incidencia INT REFERENCES incidencias(id) ON DELETE CASCADE,
    id_empleado INT REFERENCES empleados(id_usuario) ON DELETE CASCADE,
    id_administrador INT REFERENCES administradores(id) ON DELETE CASCADE,
    fecha_asignacion TIMESTAMP DEFAULT NOW(),
    fecha_finalizacion TIMESTAMP,
    estado VARCHAR(20) CHECK (estado IN ('pendiente', 'en proceso', 'completado', 'cancelado')) DEFAULT 'pendiente',
    prioridad VARCHAR(20) CHECK (prioridad IN ('baja', 'media', 'alta')) DEFAULT 'media',
    comentarios TEXT,
    evidencia_foto TEXT  -- Imagen del trabajo realizado
);

-- Tabla de Notificaciones (Para Empleados sobre Nuevas Asignaciones)
CREATE TABLE notificaciones (
    id SERIAL PRIMARY KEY,
    id_usuario INT REFERENCES usuarios(id) ON DELETE CASCADE,
    id_empleado INT REFERENCES empleados(id_usuario) ON DELETE CASCADE,
    mensaje TEXT NOT NULL,
    fecha TIMESTAMP DEFAULT NOW(),
    leido BOOLEAN DEFAULT FALSE
);

