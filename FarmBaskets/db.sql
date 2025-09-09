-- FarmBaskets database schema + seed data
CREATE DATABASE IF NOT EXISTS farmbaskets;
USE farmbaskets;

DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(120) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('customer','supplier','admin') NOT NULL,
  approved TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  supplier_id INT NULL,
  name VARCHAR(200) NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL,
  stock INT NOT NULL DEFAULT 0,
  image_url VARCHAR(500) DEFAULT 'https://images.unsplash.com/photo-1542831371-29b0f74f9713?w=800&q=80',
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (supplier_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  customer_id INT NOT NULL,
  total_amount DECIMAL(10,2) NOT NULL,
  status ENUM('pending','paid','shipped','completed','cancelled') NOT NULL DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (customer_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  quantity INT NOT NULL,
  unit_price DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- default admin (email: admin@farmbaskets.local, password: admin123)
INSERT INTO users (name,email,password_hash,role,approved) VALUES
('Admin', 'admin@farmbaskets.local', '$2y$10$2a2o5bO4fL9qH6TtTnZl2eU3mQq0YvYwZ5kWJv2lT3s6hTh.7g3fS', 'admin', 1);

-- sample supplier (email: supplier@farmbaskets.local, password: supplier123) approved
INSERT INTO users (name,email,password_hash,role,approved) VALUES
('GreenGrow Supplier', 'supplier@farmbaskets.local', '$2y$10$Tu5gVQeG5i8aF3x3Oe0yEuM8xgI1sXb6J7kY0a0O9Jj6xFh7e9K3C', 'supplier', 1);

-- sample customer (email: customer@farmbaskets.local, password: customer123)
INSERT INTO users (name,email,password_hash,role,approved) VALUES
('Demo Customer', 'customer@farmbaskets.local', '$2y$10$5iY8zv8QpY8w1dQ2o2iT2e3v1v2o3u4a5s6d7f8g9h0j1k2l3m4nO', 'customer', 1);

-- sample products
INSERT INTO products (supplier_id,name,description,price,stock,image_url,is_active) VALUES
(NULL,'Hybrid Maize Seeds','High-yield hybrid maize seeds for all seasons.', 899.00, 120, 'https://images.unsplash.com/photo-1506806732259-39c2d0268443?w=1200&q=80', 1),
(2,'Organic Tomato Seeds','Non-GMO organic tomato seeds for kitchen gardens.', 199.00, 300, 'https://images.unsplash.com/photo-1518977676601-b53f82aba655?w=1200&q=80', 1),
(2,'Neem Oil Pesticide','Natural neem oil concentrate for pest control.', 349.00, 180, 'https://images.unsplash.com/photo-1562158070-9675f4a1f1f7?w=1200&q=80', 1),
(NULL,'Wheat Seeds (HD-2967)','Popular high-yield wheat variety.', 699.00, 200, 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=1200&q=80', 1);
