-- Datenbank erstellen
CREATE DATABASE IF NOT EXISTS football_registration;
USE football_registration;

-- Teams-Tabelle erstellen
CREATE TABLE IF NOT EXISTS teams (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    team_name VARCHAR(100) NOT NULL UNIQUE
);

-- Spieler-Tabelle erstellen
CREATE TABLE IF NOT EXISTS players (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    team_id INT(11) NOT NULL,
    position VARCHAR(50) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    address TEXT NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (team_id) REFERENCES teams(id)
);

-- Standardteams einfügen
INSERT INTO teams (team_name) VALUES 
('FC Bayern München'),
('Borussia Dortmund'),
('RB Leipzig'),
('Bayer Leverkusen')
ON DUPLICATE KEY UPDATE team_name = VALUES(team_name);