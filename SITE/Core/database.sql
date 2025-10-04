CREATE TABLE IF NOT EXISTS users (
  user_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(35) NOT NULL,
  family_name VARCHAR(40) NOT NULL,
  mail VARCHAR(60) NOT NULL,
  password VARCHAR(80) NOT NULL,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL,
  email_verified_at DATETIME NULL,
  PRIMARY KEY (user_id),
  UNIQUE KEY uniq_email (mail)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users (user_id, name, family_name, mail, password)
VALUES (1, 'Alex', 'Jacob', 'alex.jacob@gmail.com', 'htt}D7*V96'),
(2, 'Ali', 'Uysun', 'ali.Uysun@orange.fr', '=fT32ds9U]'),
(3, 'Alexis', 'Babre', 'alexis.fabre@gmail.com', '84a7drL;#W'),
(4, 'Theo', 'Gheux', 'theo.gheux@gmail.com', 'wE9Q:2h7c^'),
(5, 'Amir', 'Chaoui', 'amir.chaoui@gmail.com', '9Q[c6V3w.p');