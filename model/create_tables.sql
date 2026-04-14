-- ─────────────────────────────────────────────────────────────────────────────
-- Run this in phpMyAdmin to set up the database from scratch
-- ─────────────────────────────────────────────────────────────────────────────

CREATE DATABASE IF NOT EXISTS job_platform CHARACTER SET utf8 COLLATE utf8_general_ci;

USE job_platform;

-- ─────────────────────────────────────────────────────────────────────────────
-- Main users table
-- ─────────────────────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS users (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    first_name  VARCHAR(100)                              NOT NULL,
    last_name   VARCHAR(100)                              NOT NULL,
    email       VARCHAR(150)                              NOT NULL UNIQUE,
    password    VARCHAR(255)                              NOT NULL,
    phone       VARCHAR(20)                               DEFAULT NULL,
    role        ENUM('job_seeker', 'employer', 'admin')   NOT NULL DEFAULT 'job_seeker',
    profile_pic VARCHAR(255)                              DEFAULT NULL,
    created_at  DATETIME                                  DEFAULT CURRENT_TIMESTAMP
);

-- ─────────────────────────────────────────────────────────────────────────────
-- Job postings (second entity) — linked to employers in users
-- ─────────────────────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS jobs (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    employer_id      INT          NOT NULL,
    title            VARCHAR(200) NOT NULL,
    description      TEXT         NOT NULL,
    location         VARCHAR(150) DEFAULT '',
    employment_type  ENUM('full_time', 'part_time', 'contract', 'internship') NOT NULL DEFAULT 'full_time',
    salary_range     VARCHAR(120) DEFAULT '',
    created_at       DATETIME     DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_jobs_employer FOREIGN KEY (employer_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_jobs_employer (employer_id)
);

-- ─────────────────────────────────────────────────────────────────────────────
-- If the table already exists and is missing the 'admin' role value, run this:
-- ALTER TABLE users MODIFY COLUMN role ENUM('job_seeker','employer','admin') NOT NULL DEFAULT 'job_seeker';
-- ─────────────────────────────────────────────────────────────────────────────

-- ─────────────────────────────────────────────────────────────────────────────
-- Default admin account
--   Email    : admin@workwave.com
--   Password : Admin1234
-- The hash below was generated with: password_hash('Admin1234', PASSWORD_BCRYPT)
-- ─────────────────────────────────────────────────────────────────────────────
INSERT IGNORE INTO users (first_name, last_name, email, password, phone, role)
VALUES (
    'Admin',
    'WorkWave',
    'admin@workwave.com',
    '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIXmeZv0RzxlWiq',
    NULL,
    'admin'
);
