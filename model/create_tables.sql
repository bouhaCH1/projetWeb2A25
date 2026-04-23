CREATE DATABASE IF NOT EXISTS job_platform CHARACTER SET utf8 COLLATE utf8_general_ci;
USE job_platform;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20) DEFAULT NULL,
    role ENUM('job_seeker', 'employer', 'admin') NOT NULL DEFAULT 'job_seeker',
    profile_pic VARCHAR(255) DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT IGNORE INTO users (first_name, last_name, email, password, phone, role) VALUES (
    'Admin',
    'WorkWave',
    'admin@workwave.com',
    '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIXmeZv0RzxlWiq',
    NULL,
    'admin'
);

CREATE TABLE IF NOT EXISTS mission (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employer_id INT NOT NULL,
    titre VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    budget DECIMAL(10,2) NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    statut ENUM('ouverte', 'en_cours', 'terminee') NOT NULL DEFAULT 'ouverte',
    competences TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_mission_employer FOREIGN KEY (employer_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS candidature (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mission_id INT NOT NULL,
    user_id INT NOT NULL,
    motivation TEXT NOT NULL,
    statut ENUM('en_attente', 'acceptee', 'refusee') NOT NULL DEFAULT 'en_attente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_candidature_mission FOREIGN KEY (mission_id) REFERENCES mission(id) ON DELETE CASCADE,
    CONSTRAINT fk_candidature_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
