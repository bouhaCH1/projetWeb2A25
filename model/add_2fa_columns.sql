-- Add 2FA SMS columns to users table
ALTER TABLE users 
ADD COLUMN sms_2fa_code VARCHAR(10) NULL,
ADD COLUMN sms_2fa_code_expires DATETIME NULL;
