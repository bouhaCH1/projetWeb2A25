-- FormationPHP v2 — roles: manager / client
CREATE DATABASE IF NOT EXISTS formation CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE formation;

-- Managers (anciennement enseignants)
CREATE TABLE IF NOT EXISTS managers (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nom        VARCHAR(100) NOT NULL,
    prenom     VARCHAR(100) NOT NULL,
    email      VARCHAR(200) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Clients (anciennement etudiants)
CREATE TABLE IF NOT EXISTS clients (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nom        VARCHAR(100) NOT NULL,
    prenom     VARCHAR(100) NOT NULL,
    email      VARCHAR(200) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Formations
CREATE TABLE IF NOT EXISTS formations (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    titre        VARCHAR(200) NOT NULL,
    description  TEXT,
    lieu         VARCHAR(200) DEFAULT '',
    niveau       ENUM('debutant','intermediaire','avance') DEFAULT 'debutant',
    capacite_max INT DEFAULT 0 COMMENT '0 = illimite',
    date_debut   DATE NOT NULL,
    date_fin     DATE NOT NULL,
    manager_id   INT NOT NULL,
    image_path   VARCHAR(500) DEFAULT NULL,
    video_url    VARCHAR(500) DEFAULT NULL,
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (manager_id) REFERENCES managers(id) ON DELETE CASCADE
);

-- Taches
CREATE TABLE IF NOT EXISTS taches (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    formation_id INT NOT NULL,
    titre        VARCHAR(200) NOT NULL,
    description  TEXT,
    duree        INT NOT NULL COMMENT 'heures',
    date_debut   DATE NOT NULL,
    date_fin     DATE NOT NULL,
    image_path   VARCHAR(500) DEFAULT NULL,
    video_url    VARCHAR(500) DEFAULT NULL,
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (formation_id) REFERENCES formations(id) ON DELETE CASCADE
);

-- Statuts taches par client
CREATE TABLE IF NOT EXISTS client_tache_statuts (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    tache_id   INT NOT NULL,
    client_id  INT NOT NULL,
    statut     ENUM('en_attente','en_cours','termine') NOT NULL DEFAULT 'en_attente',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_cts (tache_id, client_id),
    FOREIGN KEY (tache_id)  REFERENCES taches(id)  ON DELETE CASCADE,
    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE
);

-- Participations
CREATE TABLE IF NOT EXISTS participations (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    formation_id     INT NOT NULL,
    client_id        INT NOT NULL,
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_participation (formation_id, client_id),
    FOREIGN KEY (formation_id) REFERENCES formations(id) ON DELETE CASCADE,
    FOREIGN KEY (client_id)    REFERENCES clients(id)   ON DELETE CASCADE
);

-- Commentaires sur les taches
CREATE TABLE IF NOT EXISTS commentaires (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    tache_id    INT NOT NULL,
    auteur_id   INT NOT NULL,
    auteur_role ENUM('manager','client') NOT NULL,
    contenu     TEXT NOT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tache_id) REFERENCES taches(id) ON DELETE CASCADE
);

-- Cache traductions
CREATE TABLE IF NOT EXISTS traductions (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    source_hash CHAR(32) NOT NULL,
    source_lang VARCHAR(10) DEFAULT 'fr',
    target_lang VARCHAR(10) NOT NULL,
    traduction  TEXT NOT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_trad (source_hash, source_lang, target_lang)
);

-- Donnees de test (password = 'password')
INSERT INTO managers (nom, prenom, email, password) VALUES
  ('Dupont','Jean','jean.dupont@example.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
  ('Martin','Sophie','sophie.martin@example.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

INSERT INTO clients (nom, prenom, email, password) VALUES
  ('TREMBLAY','Alice','alice@example.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
  ('NGUYEN','Bob','bob@example.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
  ('DIALLO','Chloe','chloe@example.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
  ('BENALI','David','david@example.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

INSERT INTO formations (titre, description, lieu, niveau, capacite_max, date_debut, date_fin, manager_id) VALUES
  ('PHP Avance','Cours complet PHP natif MVC','Salle 101','avance',20,'2026-01-10','2026-03-10',1),
  ('HTML et CSS','Bases du developpement web','Salle 202','debutant',15,'2026-02-01','2026-02-28',2);

INSERT INTO taches (formation_id, titre, description, duree, date_debut, date_fin) VALUES
  (1,'Introduction MVC','Architecture MVC native PHP',3,'2026-01-10','2026-01-12'),
  (1,'PDO et MySQL','Connexion base de donnees',4,'2026-01-13','2026-01-17'),
  (1,'Formulaires','Traitement POST/GET',3,'2026-01-18','2026-01-20'),
  (2,'HTML5 Semantique','Balises modernes',2,'2026-02-01','2026-02-03');

INSERT INTO participations (formation_id, client_id) VALUES (1,1),(1,2),(2,3),(2,4);

INSERT INTO client_tache_statuts (tache_id, client_id, statut) VALUES
  (1,1,'termine'),(1,2,'termine'),
  (2,1,'en_cours'),(2,2,'en_attente'),
  (3,1,'en_attente'),(3,2,'en_attente'),
  (4,3,'termine'),(4,4,'en_cours');
