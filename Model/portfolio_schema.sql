CREATE DATABASE IF NOT EXISTS workwave6_0 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE workwave6_0;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS activity_logs, notifications, saved_jobs, applications, jobs, portfolio_projects, certificates, diplomas, freelancer_skills, company_profiles, freelancer_profiles, users;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    role ENUM('freelancer','company','admin') NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    status ENUM('active','inactive','banned') NOT NULL DEFAULT 'active',
    remember_selector VARCHAR(64) NULL UNIQUE,
    remember_validator_hash VARCHAR(255) NULL,
    remember_expires_at DATETIME NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NULL,
    INDEX idx_users_role_status (role, status)
) ENGINE=InnoDB;

CREATE TABLE freelancer_profiles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL UNIQUE,
    avatar_path VARCHAR(255) NULL,
    cv_path VARCHAR(255) NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    phone VARCHAR(50) NULL,
    address VARCHAR(255) NULL,
    city VARCHAR(100) NULL,
    governorate VARCHAR(100) NULL,
    bio TEXT NULL,
    linkedin VARCHAR(255) NULL,
    github VARCHAR(255) NULL,
    website VARCHAR(255) NULL,
    qr_token VARCHAR(64) NOT NULL UNIQUE,
    lat DECIMAL(10,7) NULL,
    lng DECIMAL(10,7) NULL,
    profile_views INT UNSIGNED NOT NULL DEFAULT 0,
    CONSTRAINT fk_freelancer_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_freelancer_city (city),
    INDEX idx_freelancer_location (lat, lng)
) ENGINE=InnoDB;

CREATE TABLE company_profiles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL UNIQUE,
    logo_path VARCHAR(255) NULL,
    company_name VARCHAR(150) NOT NULL,
    description TEXT NULL,
    industry VARCHAR(120) NULL,
    address VARCHAR(255) NULL,
    city VARCHAR(100) NULL,
    governorate VARCHAR(100) NULL,
    email VARCHAR(190) NULL,
    phone VARCHAR(50) NULL,
    website VARCHAR(255) NULL,
    lat DECIMAL(10,7) NULL,
    lng DECIMAL(10,7) NULL,
    CONSTRAINT fk_company_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_company_industry (industry),
    INDEX idx_company_location (lat, lng)
) ENGINE=InnoDB;

CREATE TABLE freelancer_skills (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    name VARCHAR(100) NOT NULL,
    category VARCHAR(100) NOT NULL,
    level TINYINT UNSIGNED NOT NULL CHECK (level BETWEEN 1 AND 100),
    CONSTRAINT fk_skill_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_skill_name (name),
    INDEX idx_skill_category (category)
) ENGINE=InnoDB;

CREATE TABLE diplomas (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    title VARCHAR(190) NOT NULL,
    institution VARCHAR(190) NOT NULL,
    graduation_year YEAR NOT NULL,
    CONSTRAINT fk_diploma_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE certificates (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    title VARCHAR(190) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL,
    CONSTRAINT fk_certificate_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE portfolio_projects (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    title VARCHAR(190) NOT NULL,
    description TEXT NULL,
    technologies VARCHAR(255) NULL,
    github_url VARCHAR(255) NULL,
    demo_url VARCHAR(255) NULL,
    image_path VARCHAR(255) NULL,
    created_at DATETIME NOT NULL,
    CONSTRAINT fk_project_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FULLTEXT idx_project_search (title, description, technologies)
) ENGINE=InnoDB;

CREATE TABLE jobs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    company_id INT UNSIGNED NOT NULL,
    title VARCHAR(190) NOT NULL,
    description TEXT NOT NULL,
    required_skills TEXT NOT NULL,
    salary DECIMAL(10,2) NOT NULL DEFAULT 0,
    location VARCHAR(150) NOT NULL,
    contract_type ENUM('remote','onsite','hybrid') NOT NULL,
    experience_level ENUM('junior','mid','senior','lead') NOT NULL,
    category VARCHAR(100) NOT NULL,
    expiration_date DATE NOT NULL,
    status ENUM('open','closed') NOT NULL DEFAULT 'open',
    created_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    CONSTRAINT fk_job_company FOREIGN KEY (company_id) REFERENCES company_profiles(id) ON DELETE CASCADE,
    INDEX idx_jobs_status_expiration (status, expiration_date),
    INDEX idx_jobs_filters (category, contract_type, location, salary),
    FULLTEXT idx_jobs_search (title, description, required_skills)
) ENGINE=InnoDB;

CREATE TABLE applications (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    job_id INT UNSIGNED NOT NULL,
    freelancer_id INT UNSIGNED NOT NULL,
    message TEXT NULL,
    status ENUM('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
    created_at DATETIME NOT NULL,
    updated_at DATETIME NULL,
    CONSTRAINT fk_application_job FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE,
    CONSTRAINT fk_application_freelancer FOREIGN KEY (freelancer_id) REFERENCES freelancer_profiles(id) ON DELETE CASCADE,
    UNIQUE KEY uq_application_once (job_id, freelancer_id),
    INDEX idx_application_status (status)
) ENGINE=InnoDB;

CREATE TABLE saved_jobs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    job_id INT UNSIGNED NOT NULL,
    created_at DATETIME NOT NULL,
    CONSTRAINT fk_saved_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_saved_job FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE,
    UNIQUE KEY uq_saved_once (user_id, job_id)
) ENGINE=InnoDB;

CREATE TABLE notifications (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    title VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    is_read TINYINT(1) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL,
    CONSTRAINT fk_notification_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_notifications_user_read (user_id, is_read)
) ENGINE=InnoDB;

CREATE TABLE activity_logs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NULL,
    action VARCHAR(100) NOT NULL,
    details VARCHAR(255) NULL,
    ip_address VARCHAR(45) NULL,
    created_at DATETIME NOT NULL,
    CONSTRAINT fk_log_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_logs_created (created_at)
) ENGINE=InnoDB;

INSERT INTO users(role,email,password_hash,status,created_at)
VALUES('admin','admin','$2y$10$nelXqG/4tuaXyMh3fmC.2OJtVGXZURTXu00LMoEplw3DRZRf/Zaf6','active',NOW());
