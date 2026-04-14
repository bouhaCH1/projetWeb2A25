-- Run this in phpMyAdmin if you already created job_platform before the jobs table existed.

USE job_platform;

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
