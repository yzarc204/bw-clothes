-- Schema đã được chỉnh sửa để cho phép xóa variant mà vẫn hiển thị order_details

CREATE TABLE `users` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `username` VARCHAR(30) UNIQUE NOT NULL,
    `email` VARCHAR(100) UNIQUE NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `name` VARCHAR(50) NOT NULL,
    `is_admin` TINYINT(1) DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE `categories` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE `sizes` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(20) NOT NULL
);

CREATE TABLE `colors` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(30) NOT NULL
);

CREATE TABLE `products` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `category_id` INT,
    `rating` FLOAT DEFAULT 0,
    `featured_image` VARCHAR(255),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE `product_variants` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `product_id` INT NOT NULL,
    `size_id` INT,
    `color_id` INT,
    `price` BIGINT NOT NULL, -- VND, integer
    `sale_price` BIGINT, -- VND, integer
    `stock_quantity` INT DEFAULT 0,
    UNIQUE KEY `unique_variant` (
        `product_id`,
        `size_id`,
        `color_id`
    )
);

CREATE TABLE `product_images` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `product_id` INT NOT NULL,
    `image_url` VARCHAR(255) NOT NULL
);

CREATE TABLE `carts` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `user_id` INT NOT NULL,
    `variant_id` INT NOT NULL,
    `quantity` INT NOT NULL,
    UNIQUE KEY `unique_cart_item` (`user_id`, `variant_id`)
);

CREATE TABLE `wishlists` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `user_id` INT NOT NULL,
    `variant_id` INT NOT NULL,
    UNIQUE KEY `unique_wishlist_item` (`user_id`, `variant_id`)
);

CREATE TABLE `orders` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `user_id` INT NOT NULL,
    `subtotal` BIGINT NOT NULL, -- Tổng tiền trước VAT, VND integer
    `vat_amount` BIGINT NOT NULL, -- Giá trị VAT (8% của subtotal), VND integer
    `shipping_fee` BIGINT NOT NULL DEFAULT 0,
    `total_amount` BIGINT NOT NULL, -- Tổng tiền sau VAT, VND integer
    `customer_name` VARCHAR(255) NOT NULL,
    `address` VARCHAR(255) NOT NULL,
    `phone_number` VARCHAR(20) NOT NULL,
    `order_time` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `shipping_time` TIMESTAMP,
    `delivered_time` TIMESTAMP,
    `status` ENUM(
        'pending',
        'processing',
        'delivering',
        'received',
        'canceled'
    ) DEFAULT 'pending'
);

CREATE TABLE `order_details` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `order_id` INT NOT NULL,
    `variant_id` INT, -- Có thể NULL nếu variant bị xóa
    `product_name` VARCHAR(255) NOT NULL,
    `size_name` VARCHAR(20),
    `color_name` VARCHAR(30),
    `price` BIGINT NOT NULL, -- VND, integer
    `product_image` VARCHAR(255) NOT NULL,
    `quantity` INT NOT NULL,
    `total_amount` BIGINT NOT NULL -- Giá sản phẩm x số lượng, VND integer, chưa bao gồm VAT
);

CREATE TABLE `ratings` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `user_id` INT NOT NULL,
    `product_id` INT NOT NULL,
    `rating` TINYINT NOT NULL CHECK (`rating` BETWEEN 1 AND 5),
    `comment` TINYTEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY `unique_rating` (`user_id`, `product_id`)
);

-- Foreign Keys

ALTER TABLE `products`
ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

ALTER TABLE `product_variants`
ADD CONSTRAINT `fk_variant_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `fk_variant_size` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE SET NULL,
ADD CONSTRAINT `fk_variant_color` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE SET NULL;

ALTER TABLE `product_images`
ADD CONSTRAINT `fk_image_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

ALTER TABLE `carts`
ADD CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `fk_cart_variant` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE;

ALTER TABLE `wishlists`
ADD CONSTRAINT `fk_wishlist_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `fk_wishlist_variant` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE;

ALTER TABLE `orders`
ADD CONSTRAINT `fk_order_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `order_details`
ADD CONSTRAINT `fk_order_detail_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `fk_order_detail_variant` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL;
-- Thay đổi để cho phép xóa variant

ALTER TABLE `ratings`
ADD CONSTRAINT `fk_rating_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `fk_rating_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;