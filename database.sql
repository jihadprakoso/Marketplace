CREATE DATABASE IF NOT EXISTS `db_marketplace_local` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_marketplace_local`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin', 'seller', 'buyer') DEFAULT 'buyer',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS `stores` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `store_name` VARCHAR(100) NOT NULL,
  `description` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT NOT NULL,
  `name` VARCHAR(150) NOT NULL,
  `description` TEXT,
  `price` DECIMAL(10, 2) NOT NULL,
  `stock` INT DEFAULT 0,
  `image` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`store_id`) REFERENCES `stores`(`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `orders` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `buyer_id` INT NOT NULL,
  `total_amount` DECIMAL(12, 2) NOT NULL,
  `status` ENUM('pending', 'paid', 'shipped', 'completed', 'cancelled') DEFAULT 'pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`buyer_id`) REFERENCES `users`(`id`) ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS `order_items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `order_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `quantity` INT NOT NULL,
  `price` DECIMAL(10, 2) NOT NULL,
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE RESTRICT
);

-- Insert a default Admin user (email: admin@marketplace.local / password: admin)
INSERT IGNORE INTO `users` (`name`, `email`, `password`, `role`) VALUES
('Administrator', 'admin@marketplace.local', '$2y$12$5w2Gv3fiJ2F4tLN9JJDN6ej.JSjHmD4Ymu0tyI80gZOcz/MlVLNzG', 'admin');

-- Sample Sellers & Buyer (password: password)
INSERT IGNORE INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(2, 'Alex Techson', 'seller@marketplace.local', '$2y$10$Q610SoHOk37YYWYnTtVsBOuiyera7KVJX0geB8pvxZonDiRrapVvS', 'seller'),
(3, 'Elena Croft', 'urbanstyle@marketplace.local', '$2y$10$I2Cm1RurbaTSw.AJ2tTMU.wL4wYXO8zYnWg5ZaXE1qD1TSc3g67.C', 'seller'),
(4, 'Budi Santoso', 'budi@marketplace.local', '$2y$10$HUeeGktyecYQQZnbu8CBfu.wDw78Uw8HTzRTG1l2j6E4tDJB4KdDS', 'buyer');

-- Sample Stores
INSERT IGNORE INTO `stores` (`id`, `user_id`, `store_name`, `description`) VALUES
(1, 2, 'TechPulse Official', 'Premium mechanical keyboards, studio audio equipment, and digital creator gear.'),
(2, 3, 'Aura Apparel Studio', 'Minimalist lifestyle backpacks, technical apparel, and everyday commute essentials.');

-- Sample Products
INSERT IGNORE INTO `products` (`id`, `store_id`, `name`, `description`, `price`, `stock`, `image`) VALUES
(1, 1, 'RGB Mechanical Keyboard Pro', 'Custom hot-swappable mechanical keyboard with RGB backlighting, sound-dampening foam, and linear switches.', 89.00, 24, 'keyboard.svg'),
(2, 1, 'Wireless ANC Studio Headphones', 'Premium active noise-canceling headphones with 40-hour battery life, spatial audio, and memory foam earcups.', 149.00, 17, 'headphones.svg'),
(3, 1, 'Smart Fitness Watch Ultra', 'Rugged titanium casing, AMOLED display, multi-sport GPS tracking, and comprehensive health monitoring.', 199.00, 12, 'smartwatch.svg'),
(4, 1, 'Ergonomic Aluminium Laptop Stand', 'Foldable aircraft-grade aluminium laptop elevator designed for heat dissipation and posture alignment.', 39.00, 40, 'laptop_stand.svg'),
(5, 2, 'Minimalist Waterproof Backpack', 'Weatherproof Cordura fabric, dedicated padded 16-inch laptop compartment, and hidden anti-theft pockets.', 59.00, 29, 'backpack.svg'),
(6, 2, 'Oversized Heavyweight Cotton Hoodie', '450 GSM French terry cotton hoodie with double-layered hood and relaxed streetwear silhouette.', 49.00, 22, 'hoodie.svg');

-- Sample Orders & Items
INSERT IGNORE INTO `orders` (`id`, `buyer_id`, `total_amount`, `status`, `created_at`) VALUES
(1, 4, 238.00, 'paid', NOW() - INTERVAL 1 DAY),
(2, 4, 59.00, 'completed', NOW() - INTERVAL 3 HOUR);

INSERT IGNORE INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 1, 1, 89.00),
(2, 1, 2, 1, 149.00),
(3, 2, 5, 1, 59.00);

