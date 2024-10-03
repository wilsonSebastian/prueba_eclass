-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS eclass;
USE eclass;

-- Crear tabla de usuarios
CREATE TABLE `users` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(100) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `role` ENUM('user', 'admin') NOT NULL,
    `status` ENUM('active', 'inactive') NOT NULL,
    `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `modified` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `token` VARCHAR(64),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Crear tabla de cursos
CREATE TABLE `courses` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `token` VARCHAR(191) UNIQUE,
    `name` VARCHAR(100) NOT NULL,
    `description` TEXT,
    `start_date` DATE,
    `end_date` DATE,
    `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `modified` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Crear tabla de relación entre usuarios y cursos
CREATE TABLE `users_courses` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `user_id` INT NOT NULL,
    `course_id` INT NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
