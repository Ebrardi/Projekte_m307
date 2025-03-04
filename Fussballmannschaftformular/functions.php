<?php
// Funktion zur Überprüfung und Bereinigung von Eingaben
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Funktion zur Validierung einer E-Mail-Adresse
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}
?>