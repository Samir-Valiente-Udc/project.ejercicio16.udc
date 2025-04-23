-- Creación de la base de datos
CREATE DATABASE IF NOT EXISTS sistema_contratos;
USE sistema_contratos;

-- Tabla de Usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ultimo_acceso DATETIME,
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    reset_token VARCHAR(255) NULL,
    reset_token_expiry DATETIME NULL
);

-- Tabla de Contratos
CREATE TABLE IF NOT EXISTS contratos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha_firma DATE NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    empresa VARCHAR(100) NOT NULL,
    empleado VARCHAR(100) NOT NULL,
    funciones TEXT NOT NULL,
    monto DECIMAL(10,2) NOT NULL,
    frecuencia_pago ENUM('semanal', 'quincenal', 'mensual', 'trimestral', 'anual') NOT NULL,
    usuario_id INT NOT NULL,
    estado ENUM('vigente', 'finalizado', 'cancelado') DEFAULT 'vigente',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion DATETIME NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Insertar datos de prueba en usuarios
INSERT INTO usuarios (username, password, nombre, email) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrador', 'admin@example.com'),
('usuario1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Usuario De Prueba', 'usuario1@example.com'),
('usuario2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Usuario Secundario', 'usuario2@example.com');

-- Insertar datos de prueba en contratos
INSERT INTO contratos (fecha_firma, fecha_inicio, fecha_fin, empresa, empleado, funciones, monto, frecuencia_pago, usuario_id) VALUES
('2025-01-15', '2025-02-01', '2026-01-31', 'Empresa A', 'Juan Pérez', 'Desarrollo de software, mantenimiento de sistemas', 5000.00, 'mensual', 1),
('2025-02-10', '2025-03-01', '2025-09-30', 'Consultora X', 'María López', 'Consultoría, análisis de datos, reportes', 4500.00, 'quincenal', 1),
('2025-03-05', '2025-04-01', '2026-03-31', 'Tech Solutions S.A', 'Carlos Gómez', 'Soporte técnico, atención al cliente', 3800.00, 'mensual', 2),
('2025-01-20', '2025-02-15', '2025-08-15', 'Digital Services ', 'Ana Martínez', 'Diseño gráfico, marketing digital', 4200.00, 'mensual', 2),
('2025-03-12', '2025-04-01', '2026-04-01', 'Innovate Inc', 'Roberto Sánchez', 'Gestión de proyectos, desarrollo de negocios', 6000.00, 'mensual', 3);