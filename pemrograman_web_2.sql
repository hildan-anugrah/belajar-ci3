DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `role` enum('administrator','operator') NOT NULL DEFAULT 'operator',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

INSERT INTO `users` VALUES 
(1, 'user1', 'ee11cbb19052e40b07aac0ca060c23ee', 'Andi Pratama', 'administrator', '2026-04-25 03:38:04'),
(2, 'user2', '6cb75f652a9b52798eb6cf2201057c73', 'Budi Santoso', 'operator', '2026-04-25 03:38:04');

-- Untuk lupa password
UPDATE users SET password = MD5('user') WHERE id = 1;