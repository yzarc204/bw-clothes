CREATE TABLE `users` (
    `id` integer PRIMARY KEY,
    `username` varchar(30) UNIQUE NOT NULL,
    `password` varchar(255) NOT NULL,
    `name` varchar(50) NOT NULL
);

CREATE TABLE `categories` (
    `id` integer PRIMARY KEY,
    `name` varchar(50) NOT NULL
);

CREATE TABLE `products` (
    `id` integer PRIMARY KEY,
    `name` varchar(255) NOT NULL,
    `price` bigint NOT NULL,
    `sale_price` bigint,
    `description` TINYTEXT,
    `category_id` integer,
    `rating` float DEFAULT 0
);

CREATE TABLE `product_images` (
    `id` integer PRIMARY KEY,
    `product_id` integer NOT NULL,
    `image_url` varchar(255) NOT NULL
);

CREATE TABLE `carts` (
    `id` integer PRIMARY KEY,
    `user_id` integer NOT NULL,
    `product_id` integer NOT NULL,
    `quantity` integer NOT NULL
);

CREATE TABLE `wishlists` (
    `id` integer PRIMARY KEY,
    `user_id` integer NOT NULL,
    `product_id` integer NOT NULL
);

CREATE TABLE `orders` (
    `id` integer PRIMARY KEY,
    `user_id` integer NOT NULL,
    `total_amount` integer NOT NULL,
    `customer_name` varchar(255) NOT NULL,
    `address` varchar(255) NOT NULL,
    `phone_number` varchar(255) NOT NULL,
    `order_time` datetime DEFAULT CURRENT_TIMESTAMP,
    `shipping_time` datetime,
    `delivered_time` datetime,
    `status` varchar(255) COMMENT 'pending, processing, delivering, received, canceled'
);

CREATE TABLE `order_details` (
    `id` integer PRIMARY KEY,
    `order_id` integer NOT NULL,
    `product_id` integer NOT NULL,
    `product_name` varchar(255) NOT NULL,
    `price` bigint NOT NULL,
    `product_image` varchar(255) NOT NULL,
    `quantity` integer NOT NULL,
    `total_amount` bigint NOT NULL
);

CREATE TABLE `ratings` (
    `id` integer PRIMARY KEY,
    `user_id` integer NOT NULL,
    `product_id` integer NOT NULL,
    `rating` integer NOT NULL,
    `comment` tinytext
);

ALTER TABLE `products`
ADD CONSTRAINT `product_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

ALTER TABLE `product_images`
ADD CONSTRAINT `product_images` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

ALTER TABLE `carts`
ADD CONSTRAINT `cart_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `carts`
ADD CONSTRAINT `cart_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

ALTER TABLE `wishlists`
ADD CONSTRAINT `wishlist_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `wishlists`
ADD CONSTRAINT `wishlist_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

ALTER TABLE `orders`
ADD CONSTRAINT `order_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `order_details`
ADD CONSTRAINT `order_order_detail` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

ALTER TABLE `ratings`
ADD CONSTRAINT `rating_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

ALTER TABLE `ratings`
ADD CONSTRAINT `rating_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);