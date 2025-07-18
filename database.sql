CREATE TABLE `users` (
    `id` integer PRIMARY KEY,
    `username` varchar(30) UNIQUE,
    `password` varchar(255),
    `name` varchar(50)
);

CREATE TABLE `categories` (
    `id` integer PRIMARY KEY,
    `name` varchar(50)
);

CREATE TABLE `products` (
    `id` integer PRIMARY KEY,
    `name` varchar(255),
    `price` bigint,
    `sale_price` bigint,
    `description` TINYTEXT,
    `category_id` integer,
    `rating` float
);

CREATE TABLE `product_images` (
    `id` integer PRIMARY KEY,
    `product_id` integer,
    `image` varchar(255)
);

CREATE TABLE `carts` (
    `id` integer PRIMARY KEY,
    `user_id` integer,
    `product_id` integer,
    `quantity` integer
);

CREATE TABLE `wishlists` (
    `id` integer PRIMARY KEY,
    `user_id` integer,
    `product_id` integer
);

CREATE TABLE `orders` (
    `id` integer PRIMARY KEY,
    `user_id` integer,
    `total_amount` integer,
    `customer_name` varchar(255),
    `address` varchar(255),
    `phone_number` varchar(255),
    `order_time` datetime DEFAULT CURRENT_TIMESTAMP,
    `shipping_time` datetime,
    `delivered_time` datetime,
    `status` varchar(255) COMMENT 'pending, processing, delivering, received, canceled'
);

CREATE TABLE `order_details` (
    `id` integer PRIMARY KEY,
    `order_id` integer,
    `product_id` integer,
    `product_name` varchar(255),
    `price` bigint,
    `product_image` varchar(255),
    `quantity` integer,
    `total_amount` bigint
);

CREATE TABLE `ratings` (
    `id` integer PRIMARY KEY,
    `user_id` integer,
    `product_id` integer,
    `rating` integer,
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