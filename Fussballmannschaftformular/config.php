<?php
// Datenbank-Konfiguration
$host = 'localhost';
$dbname = 'football_registration';
$username = 'root';
$password = 'root'; // Standard für MAMP

// Verbindung zur Datenbank herstellen
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Verbindungsfehler: " . $e->getMessage());
}
?>