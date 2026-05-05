USE job_platform;

-- Add LinkedIn profile columns to users table
ALTER TABLE users 
ADD COLUMN IF NOT EXISTS linkedin_headline TEXT,
ADD COLUMN IF NOT EXISTS linkedin_experience TEXT,
ADD COLUMN IF NOT EXISTS linkedin_skills TEXT,
ADD COLUMN IF NOT EXISTS linkedin_location VARCHAR(255),
ADD COLUMN IF NOT EXISTS linkedin_education TEXT,
ADD COLUMN IF NOT EXISTS linkedin_imported_at TIMESTAMP NULL;
