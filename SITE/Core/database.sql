CREATE TABLE IF NOT EXISTS users (
  user_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(35) NOT NULL,
  last_name VARCHAR(40) NOT NULL,
  email VARCHAR(60) NOT NULL,
  password VARCHAR(80) NOT NULL,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL,
  email_verified_at DATETIME NULL,
  PRIMARY KEY (user_id),
  UNIQUE KEY uniq_email (email)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users (user_id, name, last_name, email, password)
VALUES (1, 'Alexandre', 'Jacob', 'alexandre.jacob@etu.univ-amu.fr', 'htt}D7*V96aj'),
(2, 'Ali', 'Uysun', 'ali.uysun@etu.univ-amu.fr', '=fT32ds9U]au'),
(3, 'Alexis', 'Fabre', 'alexis.fabre@etu.univ-amu.fr', '84a7drL;#Waf'),
(4, 'Theo', 'Gheux', 'theo.gheux@etu.univ-amu.fr', 'wE9Q:2h7c^tg'),
(5, 'Amir', 'Chaoui', 'amir.taha-chaoui@etu.univ-amu.fr', '9Q[c6V3w.pac');