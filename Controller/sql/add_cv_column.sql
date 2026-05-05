-- Add cv column to candidature table
ALTER TABLE candidature ADD COLUMN cv VARCHAR(255) DEFAULT NULL AFTER motivation;
