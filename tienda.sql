-- Database: shop
-- Server: MariaDB (localhost, root user)

CREATE DATABASE IF NOT EXISTS shop
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE shop;

-- Tabla users
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla products
CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL,
  stock INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla orders
CREATE TABLE IF NOT EXISTS orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  buyer_id INT NOT NULL,
  total_price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  status INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla order_lines
CREATE TABLE IF NOT EXISTS order_lines (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  quantity INT NOT NULL,
  price DECIMAL(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Compatibilidad: vistas / tablas en singular si aún se usan
CREATE TABLE IF NOT EXISTS user LIKE users;
CREATE TABLE IF NOT EXISTS product LIKE products;

-- Productos de muestra iniciales
INSERT INTO products (name, description, price, stock) VALUES
('Auriculares Inalámbricos Pro', 'Auriculares de diadema con cancelación activa de ruido (ANC), Bluetooth 5.3 y batería de hasta 40 horas.', 149.99, 15),
('Teclado Mecánico RGB Switch Brown', 'Teclado mecánico compacto con chasis de aluminio e interruptores táctiles silenciosos.', 79.90, 20),
('Ratón Gaming Ergonómico 16000 DPI', 'Sensor óptico de alta resolución, peso ultraligero de 68g y 6 botones programables.', 45.50, 30),
('Monitor Curvo Gaming 27" 165Hz QHD', 'Panel VA 2560x1440, curvatura 1500R y 1ms de tiempo de respuesta.', 229.00, 8),
('Mochila Impermeable para Portátil 15.6"', 'Diseño antirrobo con compartimento acolchado para portátil y puerto USB exterior.', 39.95, 25),
('Soporte Ergonómico de Aluminio', 'Base plegable multialtura para portátiles de hasta 17 pulgadas.', 24.99, 18),
('Alfombrilla Gaming XXL (900x400 mm)', 'Superficie de microfibra de baja fricción y base de goma antideslizante.', 19.90, 40),
('Altavoz Inteligente con Asistente', 'Altavoz estéreo 360 grados, conectividad Wi-Fi dual band y Bluetooth.', 49.99, 12),
('Memoria SSD NVMe M.2 1TB Gen4', 'Velocidades de lectura ultrarrápidas de hasta 5000 MB/s.', 89.00, 22),
('Webcam Full HD 1080p con Micrófono', 'Cámara web con enfoque automático y tapa de privacidad.', 34.90, 16),
('Lámpara LED de Escritorio con Carga Qi', 'Luz regulable con base de carga inalámbrica rápida para smartphones.', 32.50, 14),
('Hub USB-C 7 en 1 Multifunción', 'Adaptador con HDMI 4K, 3 puertos USB 3.0, lector SD y PD 100W.', 27.99, 35);