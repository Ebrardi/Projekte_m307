<?php
// Starten der Session
session_start();

// Datenbank-Verbindung einbinden
require_once('config.php');
require_once('functions.php');

// Vordefinierte Positionen
$positions = ['Stürmer', 'Mittelfeldspieler', 'Verteidiger', 'Torwart'];

// Vorhandene Teams aus der Datenbank abrufen
$teams = [];
try {
    $stmt = $pdo->query("SELECT * FROM teams ORDER BY team_name");
    $teams = $stmt->fetchAll();
} catch (PDOException $e) {
    // Wenn die Tabelle noch nicht existiert, wird sie erstellt
    $pdo->exec("CREATE TABLE IF NOT EXISTS teams (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        team_name VARCHAR(100) NOT NULL UNIQUE
    )");
    
    // Einige Standardteams einfügen
    $defaultTeams = ['FC Bayern München', 'Borussia Dortmund', 'RB Leipzig', 'Bayer Leverkusen'];
    foreach ($defaultTeams as $team) {
        $pdo->exec("INSERT INTO teams (team_name) VALUES ('$team')");
    }
    
    // Teams erneut abrufen
    $stmt = $pdo->query("SELECT * FROM teams ORDER BY team_name");
    $teams = $stmt->fetchAll();
}

// Spieler-Tabelle erstellen, falls sie noch nicht existiert
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS players (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        team_id INT(11) NOT NULL,
        position VARCHAR(50) NOT NULL,
        full_name VARCHAR(100) NOT NULL,
        street VARCHAR(100) NOT NULL,
        house_number VARCHAR(20) NOT NULL,
        postal_code VARCHAR(10) NOT NULL,
        city VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (team_id) REFERENCES teams(id)
    )");
} catch (PDOException $e) {
    echo "Tabellenerstellungsfehler: " . $e->getMessage();
}

$errors = [];
$formData = [
    'team_id' => '',
    'new_team' => '',
    'position' => '',
    'full_name' => '',
    'street' => '',
    'house_number' => '',
    'postal_code' => '',
    'city' => '',
    'email' => ''
];

// Wenn Formular übermittelt wurde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Formular-Werte sichern
    $formData = [
        'team_id' => isset($_POST['team_id']) ? sanitizeInput($_POST['team_id']) : '',
        'new_team' => isset($_POST['new_team']) ? sanitizeInput($_POST['new_team']) : '',
        'position' => isset($_POST['position']) ? sanitizeInput($_POST['position']) : '',
        'full_name' => isset($_POST['full_name']) ? sanitizeInput($_POST['full_name']) : '',
        'street' => isset($_POST['street']) ? sanitizeInput($_POST['street']) : '',
        'house_number' => isset($_POST['house_number']) ? sanitizeInput($_POST['house_number']) : '',
        'postal_code' => isset($_POST['postal_code']) ? sanitizeInput($_POST['postal_code']) : '',
        'city' => isset($_POST['city']) ? sanitizeInput($_POST['city']) : '',
        'email' => isset($_POST['email']) ? sanitizeInput($_POST['email']) : ''
    ];
    
    // Validierung
    if (empty($formData['team_id']) && empty($formData['new_team'])) {
        $errors['team'] = 'Bitte wählen Sie eine Mannschaft aus oder geben Sie eine neue ein.';
    }
    
    if (empty($formData['position'])) {
        $errors['position'] = 'Bitte wählen Sie Ihre Position aus.';
    }
    
    if (empty($formData['full_name'])) {
        $errors['full_name'] = 'Bitte geben Sie Ihren Namen ein.';
    }
    
    if (empty($formData['street'])) {
        $errors['street'] = 'Bitte geben Sie Ihre Straße ein.';
    }
    
    if (empty($formData['house_number'])) {
        $errors['house_number'] = 'Bitte geben Sie Ihre Hausnummer ein.';
    }
    
    if (empty($formData['postal_code'])) {
        $errors['postal_code'] = 'Bitte geben Sie Ihre Postleitzahl ein.';
    }
    
    if (empty($formData['city'])) {
        $errors['city'] = 'Bitte geben Sie Ihre Stadt ein.';
    }
    
    if (empty($formData['email'])) {
        $errors['email'] = 'Bitte geben Sie Ihre E-Mail-Adresse ein.';
    } elseif (!validateEmail($formData['email'])) {
        $errors['email'] = 'Bitte geben Sie eine gültige E-Mail-Adresse ein.';
    }
    
    // Wenn keine Fehler vorliegen, Daten verarbeiten
    if (empty($errors)) {
        try {
            // Wenn neue Mannschaft angegeben wurde, diese zuerst einfügen
            $teamId = $formData['team_id'];
            
            if (!empty($formData['new_team'])) {
                $stmt = $pdo->prepare("INSERT INTO teams (team_name) VALUES (?)");
                $stmt->execute([$formData['new_team']]);
                $teamId = $pdo->lastInsertId();
            }
            
            // Spielerdaten einfügen
            $stmt = $pdo->prepare("INSERT INTO players (team_id, position, full_name, street, house_number, postal_code, city, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $teamId,
                $formData['position'],
                $formData['full_name'],
                $formData['street'],
                $formData['house_number'],
                $formData['postal_code'],
                $formData['city'],
                $formData['email']
            ]);
            
            // Erfolgsmeldung in Session speichern
            $_SESSION['success_message'] = 'Dein Formular wurde erfolgreich eingesendet. Danke für das Einschreiben!';
            
            // POST/Redirect/GET-Prinzip anwenden
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
            
        } catch (PDOException $e) {
            $errors['db'] = 'Datenbankfehler: ' . $e->getMessage();
        }
    }
    
    // Fehler in Session speichern, falls vorhanden
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['formData'] = $formData;
        
        // POST/Redirect/GET-Prinzip anwenden
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Fehler und Formular-Daten aus der Session laden
if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
}

if (isset($_SESSION['formData'])) {
    $formData = $_SESSION['formData'];
    unset($_SESSION['formData']);
}

// Erfolgsmeldung aus der Session laden
$successMessage = null;
if (isset($_SESSION['success_message'])) {
    $successMessage = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

// Registrierte Spieler abrufen
try {
    $stmt = $pdo->query("
        SELECT p.*, t.team_name 
        FROM players p
        JOIN teams t ON p.team_id = t.id
        ORDER BY p.created_at DESC
        LIMIT 10
    ");
    
    $players = $stmt->fetchAll();
} catch (PDOException $e) {
    $players = [];
}

// HTML-Template laden
include 'template.php';
?>