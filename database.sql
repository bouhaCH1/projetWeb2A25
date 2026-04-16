-- FormationPHP — schema complet
CREATE DATABASE IF NOT EXISTS formation CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE formation;

CREATE TABLE IF NOT EXISTS enseignants (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nom        VARCHAR(100) NOT NULL,
    prenom     VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS etudiants (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nom        VARCHAR(100) NOT NULL,
    prenom     VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS formations (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    titre         VARCHAR(200) NOT NULL,
    description   TEXT,
    lieu          VARCHAR(200) DEFAULT '',
    niveau        ENUM('debutant','intermediaire','avance') DEFAULT 'debutant',
    capacite_max  INT DEFAULT 0 COMMENT '0 = illimite',
    date_debut    DATE NOT NULL,
    date_fin      DATE NOT NULL,
    enseignant_id INT NOT NULL,
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (enseignant_id) REFERENCES enseignants(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS taches (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    formation_id INT NOT NULL,
    titre        VARCHAR(200) NOT NULL,
    description  TEXT,
    duree        INT NOT NULL COMMENT 'heures',
    date_debut   DATE NOT NULL,
    date_fin     DATE NOT NULL,
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (formation_id) REFERENCES formations(id) ON DELETE CASCADE
);

-- Statut individuel par etudiant pour chaque tache
CREATE TABLE IF NOT EXISTS etudiant_tache_statuts (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    tache_id    INT NOT NULL,
    etudiant_id INT NOT NULL,
    statut      ENUM('en_attente','en_cours','termine') NOT NULL DEFAULT 'en_attente',
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_ets (tache_id, etudiant_id),
    FOREIGN KEY (tache_id)    REFERENCES taches(id)    ON DELETE CASCADE,
    FOREIGN KEY (etudiant_id) REFERENCES etudiants(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS participations (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    formation_id     INT NOT NULL,
    etudiant_id      INT NOT NULL,
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_participation (formation_id, etudiant_id),
    FOREIGN KEY (formation_id) REFERENCES formations(id)  ON DELETE CASCADE,
    FOREIGN KEY (etudiant_id)  REFERENCES etudiants(id)   ON DELETE CASCADE
);

-- Donnees de test
INSERT INTO enseignants (nom, prenom) VALUES ('Dupont','Jean'),('Martin','Sophie');
INSERT INTO etudiants   (nom, prenom) VALUES ('TREMBLAY','Alice'),('NGUYEN','Bob'),('DIALLO','Chloe'),('BENALI','David');

INSERT INTO formations (titre, description, lieu, niveau, capacite_max, date_debut, date_fin, enseignant_id) VALUES
  ('PHP Avance','Cours complet PHP natif MVC','Salle 101','avance',20,'2026-01-10','2026-03-10',1),
  ('HTML et CSS','Bases du developpement web','Salle 202','debutant',15,'2026-02-01','2026-02-28',2);

INSERT INTO taches (formation_id, titre, description, duree, date_debut, date_fin) VALUES
  (1,'Introduction MVC','Architecture MVC native PHP',3,'2026-01-10','2026-01-12'),
  (1,'PDO et MySQL','Connexion base de donnees',4,'2026-01-13','2026-01-17'),
  (1,'Formulaires','Traitement POST/GET',3,'2026-01-18','2026-01-20'),
  (2,'HTML5 Semantique','Balises modernes',2,'2026-02-01','2026-02-03');

INSERT INTO participations (formation_id, etudiant_id) VALUES (1,1),(1,2),(2,3),(2,4);

INSERT INTO etudiant_tache_statuts (tache_id, etudiant_id, statut) VALUES
  (1,1,'termine'),(1,2,'termine'),
  (2,1,'en_cours'),(2,2,'en_attente'),
  (3,1,'en_attente'),(3,2,'en_attente'),
  (4,3,'termine'),(4,4,'en_cours');
