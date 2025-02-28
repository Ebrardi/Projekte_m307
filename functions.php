<?php
// Hilfsfunktionen

// Funktion zur Eingabevalidierung
function validateInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Teams aus Datenbank abrufen
function getTeams($pdo) {
    return $pdo->query("SELECT * FROM teams ORDER BY team_name")->fetchAll();
}

// Positionen aus Datenbank abrufen
function getPositions($pdo) {
    return $pdo->query("SELECT * FROM positions ORDER BY position_name")->fetchAll();
}

// Neues Team hinzufügen
function addTeam($pdo, $teamName) {
    try {
        $stmt = $pdo->prepare("INSERT INTO teams (team_name) VALUES (?)");
        $stmt->execute([$teamName]);
        return true;
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Duplicate entry
            return "duplicate";
        } else {
            return false;
        }
    }
}

// Spieler in Datenbank speichern
function savePlayer($pdo, $firstName, $lastName, $address, $email, $teamId, $positionId) {
    try {
        $stmt = $pdo->prepare("INSERT INTO players (first_name, last_name, address, email, team_id, position_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$firstName, $lastName, $address, $email, $teamId, $positionId]);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}
?>