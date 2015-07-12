ALTER TABLE `orders` ADD COLUMN `total` decimal(8, 2) DEFAULT 0.00 NOT NULL AFTER `customer_id`;
ALTER TABLE `orders` MODIFY COLUMN `customer_id` int(11) unsigned NOT NULL;
ALTER TABLE `orders` ADD CONSTRAINT `fk_orders_users` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;

CREATE TABLE IF NOT EXISTS `order_products` (
  `id` int(11) unsigned AUTO_INCREMENT,
  `order_id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `product_name` varchar(255) NOT NULL, /* why this? we should save the product details... maybe in time the product name / cost will be changed */
  `product_cost` decimal(8, 2) DEFAULT 0.00 NOT NULL,
  `quantity` tinyint(3) DEFAULT 0 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_order_products_orders` (`order_id`),
  CONSTRAINT `fk_order_products_orders` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  KEY `fk_order_products_products` (`product_id`),
  CONSTRAINT `fk_order_products_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/* some test products */
INSERT INTO `products` (`name`, `cost`) VALUES
  ('Burritos', 13.37),
  ('Pizza', 11.11),
  ('Random food :|', 10.00);
