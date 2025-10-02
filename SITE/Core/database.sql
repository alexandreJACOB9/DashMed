CREATE TABLE IF NOT EXISTS users (
  user_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(35) NOT NULL,
  family_name VARCHAR(40) NOT NULL,
  mail VARCHAR(60) NOT NULL,
  password VARCHAR(80) NOT NULL,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL,
  email_verified_at DATETIME NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uniq_email (email)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
