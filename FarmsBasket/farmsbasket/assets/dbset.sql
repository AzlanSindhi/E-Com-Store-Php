-- Create database
CREATE DATABASE IF NOT EXISTS farmsbasket CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE farmsbasket;

-- ROLES
DROP TABLE IF EXISTS roles;
CREATE TABLE roles (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL UNIQUE
);
INSERT INTO roles (name) VALUES ('admin'), ('customer'), ('supplier');

-- USERS
DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL, -- kept plain for simplicity in project
  role_id INT NOT NULL,
  status ENUM('active','inactive') DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (role_id) REFERENCES roles(id)
);

-- CATEGORIES
DROP TABLE IF EXISTS categories;
CREATE TABLE categories (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  slug VARCHAR(120) NOT NULL UNIQUE
);
INSERT INTO categories (name, slug) VALUES
('Seeds', 'seeds'),
('Pesticides', 'pesticides');

-- PRODUCTS
DROP TABLE IF EXISTS products;
CREATE TABLE products (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(150) NOT NULL,
  slug VARCHAR(180) NOT NULL UNIQUE,
  category_id INT NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL,
  unit VARCHAR(30) DEFAULT 'kg',
  stock INT DEFAULT 0,
  image_url VARCHAR(255),
  is_active TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL,
  FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- SUPPLIERS
DROP TABLE IF EXISTS suppliers;
CREATE TABLE suppliers (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(150) UNIQUE,
  phone VARCHAR(30),
  address VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- PRODUCT ↔ SUPPLIER link (many-to-many)
DROP TABLE IF EXISTS product_suppliers;
CREATE TABLE product_suppliers (
  product_id INT NOT NULL,
  supplier_id INT NOT NULL,
  PRIMARY KEY (product_id, supplier_id),
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
  FOREIGN KEY (supplier_id) REFERENCES suppliers(id) ON DELETE CASCADE
);

-- Seed sample products (Seeds + Pesticides)
INSERT INTO products (name, slug, category_id, description, price, unit, stock, image_url) VALUES
('Hybrid Maize Seeds MZ-21', 'hybrid-maize-seeds-mz-21', 1, 'High-yield hybrid maize seeds suitable for varied climates.', 1299.00, '5 kg', 40, 'https://images.unsplash.com/photo-1604335399105-0d7bf1e9c5a1?q=80&w=1200&auto=format&fit=crop'),
('Organic Wheat Seeds W-9', 'organic-wheat-seeds-w-9', 1, 'Certified organic wheat seeds for robust growth.', 899.00, '5 kg', 60, 'https://images.unsplash.com/photo-1560785496-3c9c8f8a0dcf?q=80&w=1200&auto=format&fit=crop'),
('Neem Oil Insecticide 1L', 'neem-oil-insecticide-1l', 2, 'Natural pest control, effective against aphids & mites.', 449.00, '1 L', 120, 'https://images.unsplash.com/photo-1615485737657-0e4fc3b5f520?q=80&w=1200&auto=format&fit=crop'),
('GlyphoX Herbicide 500ml', 'glyphox-herbicide-500ml', 2, 'Systemic herbicide for broad-spectrum weed control.', 699.00, '500 ml', 80, 'https://images.unsplash.com/photo-1568640347023-2d4bb9b0fa49?q=80&w=1200&auto=format&fit=crop');
