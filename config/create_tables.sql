-- Run this in phpMyAdmin before starting

CREATE DATABASE IF NOT EXISTS job_platform CHARACTER SET utf8 COLLATE utf8_general_ci;

USE job_platform;

CREATE TABLE IF NOT EXISTS users (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    first_name  VARCHAR(100)                    NOT NULL,
    last_name   VARCHAR(100)                    NOT NULL,
    email       VARCHAR(150)                    NOT NULL UNIQUE,
    password    VARCHAR(255)                    NOT NULL,
    phone       VARCHAR(20)                     DEFAULT NULL,
    role        ENUM('job_seeker', 'employer')  NOT NULL DEFAULT 'job_seeker',
    profile_pic VARCHAR(255)                    DEFAULT NULL,
    created_at  DATETIME                        DEFAULT CURRENT_TIMESTAMP
);
