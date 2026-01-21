DROP DATABASE IF EXISTS st_hogar;
CREATE DATABASE st_hogar
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE st_hogar;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS mantenimientos;
DROP TABLE IF EXISTS ventas;
DROP TABLE IF EXISTS servicios;
DROP TABLE IF EXISTS equipos;
DROP TABLE IF EXISTS clientes;
DROP TABLE IF EXISTS usuarios;

SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE usuarios (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(100) NOT NULL,
  apellido VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  rol ENUM('admin','tecnico','ventas') NOT NULL DEFAULT 'tecnico',
  activo TINYINT(1) NOT NULL DEFAULT 1,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_usuarios_email (email),
  KEY idx_usuarios_rol (rol)
) ENGINE=InnoDB;

CREATE TABLE clientes (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(100) NOT NULL,
  apellido VARCHAR(100) NOT NULL,
  email VARCHAR(150) NULL,
  telefono VARCHAR(30) NULL,
  direccion VARCHAR(255) NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_clientes_email (email),
  KEY idx_clientes_nombre (nombre, apellido)
) ENGINE=InnoDB;

CREATE TABLE equipos (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  cliente_id BIGINT UNSIGNED NOT NULL,
  tipo VARCHAR(80) NOT NULL,
  marca VARCHAR(80) NULL,
  modelo VARCHAR(80) NULL,
  numero_serie VARCHAR(120) NULL,
  descripcion TEXT NULL,
  fecha_registro DATE NOT NULL,
  estado ENUM('activo','en_mantenimiento','retirado') NOT NULL DEFAULT 'activo',
  PRIMARY KEY (id),
  KEY idx_equipos_cliente (cliente_id),
  KEY idx_equipos_estado (estado),
  CONSTRAINT fk_equipos_clientes
    FOREIGN KEY (cliente_id) REFERENCES clientes (id)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE servicios (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  cliente_id BIGINT UNSIGNED NOT NULL,
  usuario_id BIGINT UNSIGNED NOT NULL,
  descripcion TEXT NOT NULL,
  estado ENUM('pendiente','en_proceso','finalizado','cancelado') NOT NULL DEFAULT 'pendiente',
  fecha_solicitud DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  fecha_cierre DATETIME NULL,
  costo_estimado DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (id),
  KEY idx_servicios_cliente (cliente_id),
  KEY idx_servicios_usuario (usuario_id),
  KEY idx_servicios_estado (estado),
  CONSTRAINT fk_servicios_clientes
    FOREIGN KEY (cliente_id) REFERENCES clientes (id)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_servicios_usuarios
    FOREIGN KEY (usuario_id) REFERENCES usuarios (id)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE ventas (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  cliente_id BIGINT UNSIGNED NOT NULL,
  usuario_id BIGINT UNSIGNED NOT NULL,
  fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  notas TEXT NULL,
  PRIMARY KEY (id),
  KEY idx_ventas_cliente (cliente_id),
  KEY idx_ventas_usuario (usuario_id),
  KEY idx_ventas_fecha (fecha),
  CONSTRAINT fk_ventas_clientes
    FOREIGN KEY (cliente_id) REFERENCES clientes (id)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_ventas_usuarios
    FOREIGN KEY (usuario_id) REFERENCES usuarios (id)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE mantenimientos (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  equipo_id BIGINT UNSIGNED NOT NULL,
  servicio_id BIGINT UNSIGNED NULL,
  usuario_id BIGINT UNSIGNED NOT NULL,
  fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  descripcion TEXT NOT NULL,
  costo DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  proximo_mantenimiento DATE NULL,
  PRIMARY KEY (id),
  KEY idx_mantenimientos_equipo (equipo_id),
  KEY idx_mantenimientos_servicio (servicio_id),
  KEY idx_mantenimientos_usuario (usuario_id),
  CONSTRAINT fk_mantenimientos_equipos
    FOREIGN KEY (equipo_id) REFERENCES equipos (id)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_mantenimientos_servicios
    FOREIGN KEY (servicio_id) REFERENCES servicios (id)
    ON UPDATE CASCADE ON DELETE SET NULL,
  CONSTRAINT fk_mantenimientos_usuarios
    FOREIGN KEY (usuario_id) REFERENCES usuarios (id)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

INSERT INTO usuarios (nombre, apellido, email, password_hash, rol, activo)
VALUES (
  'Admin',
  'ST-Hogar',
  'admin@st-hogar.local',
  '$2y$12$4H5GCmfIHvZ06ruozCe1JOOwHFKFw1hZcWfaBSmuxgcNSiDu5cI12',
  'admin',
  1
);