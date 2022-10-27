-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 16-09-2020 a las 16:37:17
-- Versión del servidor: 10.5.5-MariaDB-1:10.5.5+maria~focal
-- Versión de PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: database
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla USERS
--

CREATE TABLE users (
  id int NOT NULL AUTO_INCREMENT,
  full_name varchar(256) NOT NULL,
  dni varchar(256) NOT NULL,
  birth_date date NOT NULL,
  phone int(9) NOT NULL,
  email varchar(256) NOT NULL,
  password varchar(256) NOT NULL,
  user_name varchar(256) NOT NULL UNIQUE,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Estructura de tabla para la tabla CATEGORIES
--

CREATE TABLE categories (
  id int NOT NULL AUTO_INCREMENT,
  name varchar(256) NOT NULL, 
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Estructura de tabla para la tabla PRODUCTS
--

CREATE TABLE products (
  id int NOT NULL AUTO_INCREMENT,
  user_id int(11), 
  name varchar(256) NOT NULL,
  brand varchar(256) NOT NULL,
  size varchar(256) NOT NULL,
  color varchar(256) NOT NULL,
  category_id int(11) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (category_id) REFERENCES categories(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO users (full_name, dni, birth_date, phone, email, password, user_name) VALUES
('Daniela Waldeck', '18541555-J', '1995-07-15', 999999999, 'danielawaldeck95@gmail.com', '12345678', 'daniwal'),
('Pedro Inciarte', '16760377-R', '2001-06-20', 999999999, 'pedro.iniciarte13@gmail.com', '12345678', 'peli');

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO categories (name) VALUES
('Zapatos'),
('Camisetas'),
('Abrigo'),
('Pantalones');

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO products (user_id, name, brand, size, color, category_id) VALUES
(1, 'pantalon negro', 'ZARA', 'm', 'negro', 4),
(1, 'zapatos negros', 'vans', '38', 'negro', 1),
(1, 'camiseta blanca', 'hym', 'm', 'blanco', 2),
(2, 'hoodie', 'hym', 'xl', 'gris', 3);
