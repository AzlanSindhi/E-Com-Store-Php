-- FarmBasket schema + sample data
CREATE DATABASE IF NOT EXISTS farmbasket CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE farmbasket;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(200) NOT NULL,
  short_description VARCHAR(255),
  description TEXT,
  price DECIMAL(10,2) NOT NULL,
  image_url VARCHAR(500),
  category_id INT NOT NULL,
  is_active TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  customer_name VARCHAR(150) NOT NULL,
  phone VARCHAR(30) NOT NULL,
  address TEXT NOT NULL,
  subtotal DECIMAL(10,2) NOT NULL,
  tax DECIMAL(10,2) NOT NULL,
  total DECIMAL(10,2) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  product_name VARCHAR(200) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  qty INT NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

-- seed data
INSERT INTO categories (name) VALUES
('Seeds'),('Pesticides'),('Fertilizers');

INSERT INTO products (name, short_description, description, price, image_url, category_id, is_active) VALUES
('Hybrid Maize Seeds', 'High yield Kharif variety', 'Suitable for Kharif season, drought tolerant, 120-130 days maturity.', 1299.00, 'https://images.unsplash.com/photo-1563201180-1f1a0ebf4631?q=80&w=1200&auto=format&fit=crop', 1, 1),
('Paddy Seeds (IR-64)', 'Popular paddy variety', 'Good tillering, medium duration, recommended for irrigated areas.', 899.00, 'https://images.unsplash.com/photo-1549880338-65ddcdfd017b?q=80&w=1200&auto=format&fit=crop', 1, 1),
('Cotton Seeds BT', 'Insect resistant', 'Early maturing hybrid cotton with strong boll retention.', 1599.00, 'https://images.unsplash.com/photo-1606923829579-0cb981e59505?q=80&w=1200&auto=format&fit=crop', 1, 1),
('Glyphosate 41% SL', 'Systemic herbicide', 'Non-selective herbicide for post-emergence weed control.', 749.00, 'https://images.unsplash.com/photo-1560114927-6ae7c0c544f0?q=80&w=1200&auto=format&fit=crop', 2, 1),
('Imidacloprid 17.8% SL', 'Insecticide', 'Effective against sucking pests in cotton, paddy & vegetables.', 599.00, 'https://images.unsplash.com/photo-1615484477518-4c9de282bc33?q=80&w=1200&auto=format&fit=crop', 2, 1),
('Urea 46% N', 'Nitrogen fertilizer', 'Boosts vegetative growth in cereals and vegetables.', 499.00, 'https://images.unsplash.com/photo-1609390959910-b745b1b74b09?q=80&w=1200&auto=format&fit=crop', 3, 1);

-- admin user: email admin@farmbasket.local / password admin123
INSERT INTO users (name, email, password_hash) VALUES
('Admin', 'admin@farmbasket.local', '$2y$10$0KmX0Q1s2S7a.9tdG.v9xumA2mwoeKjLxQwUjI8w5oU1sGZHRxBSe');
