CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(1024) NOT NULL
);

CREATE TABLE `attractions` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title_compiled` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `site_url` varchar(255) NOT NULL,
  `qr-code_path` varchar(255) NOT NULL,
  `created_by` INT NOT NULL,
  FOREIGN KEY (`created_by`) REFERENCES `users`(`id`)
);