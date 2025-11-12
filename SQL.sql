CREATE DATABASE base_usuarios
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE base_usuarios;

CREATE TABLE usuarios (
  id               INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre           VARCHAR(150)  NOT NULL,
  correo           VARCHAR(190)  NOT NULL,
  telefono         VARCHAR(30)   NOT NULL,
  fecha_nacimiento DATE          NOT NULL,
  ciudad           VARCHAR(120)  NOT NULL,
  contrasena       VARCHAR(255)  NOT NULL,

  fecha_registro   TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (id),
  UNIQUE KEY uq_usuarios_correo (correo)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;