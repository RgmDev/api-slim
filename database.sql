CREATE DATABASE IF NOT EXISTS api_slim;
USE api_slim;

DROP TABLE IF EXISTS users;
CREATE TABLE users(
  id int(10) UNSIGNED NOT NULL,
  first_name varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  last_name varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  email varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  password varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE users
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY users_email_unique (email);

ALTER TABLE users
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

-- password: pass
INSERT INTO users (first_name, last_name, email, password) VALUES ('user', 'pass', 'user@pass', '$2y$10$ITIN3SaPqeZ4IYYg3YpSweGU83ObnLkqeG1FkdWjzb5eeOZd5S6zC');
