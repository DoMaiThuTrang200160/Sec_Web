-- LƯU Ý: nếu import bằng dòng lệnh, dùng: mysql -u root --default-character-set=utf8mb4 < laptop_shop.sql
-- (Nếu import qua phpMyAdmin thì không cần lo, phpMyAdmin tự xử lý charset đúng)
CREATE DATABASE IF NOT EXISTS laptop_shop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE laptop_shop;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    role ENUM('admin', 'customer') NOT NULL DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    slug VARCHAR(150) NOT NULL,
    price DECIMAL(12,0) NOT NULL,
    discount_price DECIMAL(12,0) NULL,
    description TEXT,
    image VARCHAR(255),
    brand VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address VARCHAR(255) NOT NULL,
    total DECIMAL(14,0) NOT NULL,
    status ENUM('pending','confirmed','shipping','completed','cancelled') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE order_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(12,0) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Tài khoản admin mẫu: email admin@laptopshop.local / mật khẩu admin123
-- (hash bcrypt thật, password_verify() trong AuthController sẽ xác thực được ngay)
INSERT INTO users (username, email, password, full_name, role) VALUES
('admin', 'admin@laptopshop.local', '$2b$10$NCpP8HHx4AgSNO6e2CAPc.OlimbQxokrvTpmd4PfkMtD.yQDNtAs6', 'Quản trị viên', 'admin');

INSERT INTO categories (name, slug) VALUES
('Laptop AI', 'laptop-ai'),
('Gaming - Đồ họa', 'gaming-do-hoa'),
('Sinh viên - Văn phòng', 'sinh-vien-van-phong'),
('Mỏng nhẹ', 'mong-nhe'),
('Doanh nhân', 'doanh-nhan');

-- Vài sản phẩm mẫu để test trang home/productList/productDetail ngay
INSERT INTO products (category_id, name, slug, price, discount_price, description, image, brand) VALUES
(1, 'Laptop Acer Aspire Lite 14', 'acer-aspire-lite-14', 17990000, NULL, 'Laptop AI mỏng nhẹ, pin trâu, phù hợp học tập.', '', 'Acer'),
(1, 'Laptop HP 250 G10', 'hp-250-g10', 21890000, NULL, 'Hiệu năng ổn định cho công việc văn phòng và AI cơ bản.', '', 'HP'),
(2, 'Asus ROG Strix G16', 'asus-rog-strix-g16', 35990000, NULL, 'Laptop gaming hiệu năng cao, màn hình 165Hz.', '', 'Asus'),
(3, 'Asus Vivobook X1404VA', 'asus-vivobook-x1404va', 21990000, NULL, 'Laptop sinh viên - văn phòng, nhẹ, pin tốt.', '', 'Asus'),
(4, 'Dell 14 DC14250', 'dell-14-dc14250', 25490000, NULL, 'Thiết kế mỏng nhẹ, màn hình chống chói.', '', 'Dell'),
(5, 'Lenovo ThinkPad E14', 'lenovo-thinkpad-e14', 27990000, NULL, 'Dòng doanh nhân, bảo mật vân tay, bền bỉ.', '', 'Lenovo');
