-- Danino Tournée Pédiatre — MySQL 8 / PHP 8.2
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS danino_tournee CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE danino_tournee;

DROP TABLE IF EXISTS visite_photos;
DROP TABLE IF EXISTS visite_cadeaux;
DROP TABLE IF EXISTS stock_mouvements;
DROP TABLE IF EXISTS visites;
DROP TABLE IF EXISTS cadeaux;
DROP TABLE IF EXISTS medecins;
DROP TABLE IF EXISTS etablissements;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin','gestionnaire','statistiques','delegue') NOT NULL,
  active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE etablissements (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(190) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE medecins (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  fullname VARCHAR(190) NOT NULL,
  type TINYINT UNSIGNED NOT NULL DEFAULT 1 COMMENT '1=pediatre 2=sage-femme',
  region VARCHAR(120) DEFAULT NULL,
  municipalite VARCHAR(120) DEFAULT NULL,
  etab TINYINT UNSIGNED DEFAULT NULL COMMENT '1=hopital 2=clinique 3=cabinet',
  name_etab VARCHAR(190) DEFAULT NULL,
  adresse VARCHAR(255) DEFAULT NULL,
  tel VARCHAR(60) DEFAULT NULL,
  email VARCHAR(190) DEFAULT NULL,
  classe ENUM('A','A+','B','C') DEFAULT NULL,
  active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_medecins_fullname (fullname),
  INDEX idx_medecins_region (region)
) ENGINE=InnoDB;

CREATE TABLE cadeaux (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(190) NOT NULL,
  image_path VARCHAR(255) DEFAULT NULL,
  stock INT NOT NULL DEFAULT 0,
  seuil_alerte INT NOT NULL DEFAULT 10,
  active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_cadeaux_active (active)
) ENGINE=InnoDB;

CREATE TABLE visites (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  medecin_id INT UNSIGNED NOT NULL,
  delegue_id INT UNSIGNED NOT NULL,
  nvisite TINYINT UNSIGNED NOT NULL DEFAULT 1,
  classe ENUM('A','A+','B','C') DEFAULT NULL,
  region VARCHAR(120) DEFAULT NULL,
  municipalite VARCHAR(120) DEFAULT NULL,
  etab TINYINT UNSIGNED DEFAULT NULL,
  name_etab VARCHAR(190) DEFAULT NULL,
  gps VARCHAR(80) DEFAULT NULL,
  remarque TEXT DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_visites_medecin FOREIGN KEY (medecin_id) REFERENCES medecins(id),
  CONSTRAINT fk_visites_delegue FOREIGN KEY (delegue_id) REFERENCES users(id),
  INDEX idx_visites_delegue_date (delegue_id, created_at),
  INDEX idx_visites_created (created_at)
) ENGINE=InnoDB;

CREATE TABLE visite_cadeaux (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  visite_id INT UNSIGNED NOT NULL,
  cadeau_id INT UNSIGNED NOT NULL,
  qty INT UNSIGNED NOT NULL,
  CONSTRAINT fk_vc_visite FOREIGN KEY (visite_id) REFERENCES visites(id) ON DELETE CASCADE,
  CONSTRAINT fk_vc_cadeau FOREIGN KEY (cadeau_id) REFERENCES cadeaux(id)
) ENGINE=InnoDB;

CREATE TABLE visite_photos (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  visite_id INT UNSIGNED NOT NULL,
  path VARCHAR(255) NOT NULL,
  sort_order TINYINT UNSIGNED NOT NULL DEFAULT 0,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_vp_visite FOREIGN KEY (visite_id) REFERENCES visites(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE stock_mouvements (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  cadeau_id INT UNSIGNED NOT NULL,
  type ENUM('in','out','adjust') NOT NULL,
  qty INT NOT NULL,
  user_id INT UNSIGNED DEFAULT NULL,
  visite_id INT UNSIGNED DEFAULT NULL,
  note VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_sm_cadeau FOREIGN KEY (cadeau_id) REFERENCES cadeaux(id),
  CONSTRAINT fk_sm_user FOREIGN KEY (user_id) REFERENCES users(id),
  CONSTRAINT fk_sm_visite FOREIGN KEY (visite_id) REFERENCES visites(id) ON DELETE SET NULL
) ENGINE=InnoDB;

SET FOREIGN_KEY_CHECKS = 1;

-- Seeds (mot de passe pour tous : Danino2026!)
INSERT INTO users (name, email, password_hash, role, active) VALUES
('Administrateur', 'admin@danino.local', '$2y$10$k1Pdtpuo0VkC1u6ULcAv8.fqGxocE69AyUHQZCpsZxq8gvUYw8I1u', 'admin', 1),
('Gestionnaire Stock', 'gestionnaire@danino.local', '$2y$10$k1Pdtpuo0VkC1u6ULcAv8.fqGxocE69AyUHQZCpsZxq8gvUYw8I1u', 'gestionnaire', 1),
('Lecture Stats', 'stats@danino.local', '$2y$10$k1Pdtpuo0VkC1u6ULcAv8.fqGxocE69AyUHQZCpsZxq8gvUYw8I1u', 'statistiques', 1),
('Délégué Médical', 'delegue@danino.local', '$2y$10$k1Pdtpuo0VkC1u6ULcAv8.fqGxocE69AyUHQZCpsZxq8gvUYw8I1u', 'delegue', 1);

INSERT INTO etablissements (name) VALUES
('Hôpital Charles Nicolle'),
('Clinique El Manar'),
('Cabinet Dr. Example');

INSERT INTO cadeaux (name, stock, seuil_alerte, active) VALUES
('Mug Danino', 100, 20, 1),
('Carnet de santé', 200, 40, 1),
('Toise', 50, 10, 1),
('Porte abaisse-langue', 80, 15, 1);

INSERT INTO medecins (fullname, type, region, municipalite, etab, name_etab, adresse, tel, classe, active) VALUES
('Dr. Amine Ben Salah', 1, 'Tunis', 'Tunis', 3, 'Cabinet Dr. Amine', 'Centre Urbain Nord', '20123456', 'A', 1),
('Sf. Leila Trabelsi', 2, 'Ariana', 'Ariana', 1, 'Hôpital Charles Nicolle', 'Ariana', '98111222', 'B', 1);
