-- Add categorie and niveau columns to mission table
ALTER TABLE mission ADD COLUMN categorie VARCHAR(50) DEFAULT NULL AFTER competences;
ALTER TABLE mission ADD COLUMN niveau VARCHAR(50) DEFAULT NULL AFTER categorie;
