<?php
// Session starten
session_start();

// Datenbankverbindung und Funktionen einbinden
require_once 'config.php';
require_once 'functions.php';

// Initialisierung
$errors = [];
$formData = [];

// Standard-Werte aus der Session laden, falls vorhanden
if (isset($_SESSION['form_data'])) {
    $formData = $_SESSION['form_data'];
}

// POST-Verarbeitung
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Neues Team hinzufügen
    if (isset($_POST['add_team']) && !empty($_POST['new_team'])) {
        $newTeam = validateInput($_POST['new_team']);
        
        $result = addTeam($pdo, $newTeam);
        if ($result === "duplicate") {
            $errors['new_team'] = "Dieses Team existiert bereits.";
        } elseif ($result === false) {
            $errors['new_team'] = "Fehler beim Hinzufügen des Teams.";
        } else {
            // Erfolgreich, Seite neu laden
            header("Location: ".$_SERVER['PHP_SELF']);
            exit;
        }
    }
    
    // Formular-Einreichung
    if (isset($_POST['submit'])) {
        // Werte sammeln
        $teamId = isset($_POST['team']) ? validateInput($_POST['team']) : '';
        $positionId = isset($_POST['position']) ? validateInput($_POST['position']) : '';
        $firstName = isset($_POST['first_name']) ? validateInput($_POST['first_name']) : '';
        $lastName = isset($_POST['last_name']) ? validateInput($_POST['last_name']) : '';
        $address = isset($_POST['address']) ? validateInput($_POST['address']) : '';
        $email = isset($_POST['email']) ? validateInput($_POST['email']) : '';
        
        // Validierung
        if (empty($teamId)) {
            $errors['team'] = "Bitte wähle eine Mannschaft aus.";
        }
        
        if (empty($positionId)) {
            $errors['position'] = "Bitte wähle eine Position aus.";
        }
        
        if (empty($firstName)) {
            $errors['first_name'] = "Bitte gib deinen Vornamen ein.";
        }
        
        if (empty($lastName)) {
            $errors['last_name'] = "Bitte gib deinen Nachnamen ein.";
        }
        
        if (empty($address)) {
            $errors['address'] = "Bitte gib deine Adresse ein.";
        }
        
        if (empty($email)) {
            $errors['email'] = "Bitte gib deine E-Mail-Adresse ein.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Bitte gib eine gültige E-Mail-Adresse ein.";
        }
        
        // Daten speichern für Wiederbefüllung
        $formData = [
            'team' => $teamId,
            'position' => $positionId,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'address' => $address,
            'email' => $email
        ];
        $_SESSION['form_data'] = $formData;
        
        // Wenn keine Fehler, in Datenbank speichern und weiterleiten
        if (empty($errors)) {
            $result = savePlayer($pdo, $firstName, $lastName, $address, $email, $teamId, $positionId);
            
            if ($result) {
                // POST/Redirect/GET-Prinzip anwenden
                $_SESSION['success_message'] = "Dein Formular wurde erfolgreich eingesendet. Danke für das Einschreiben!";
                unset($_SESSION['form_data']); // Formulardaten löschen
                header("Location: ".$_SERVER['PHP_SELF']);
                exit;
            } else {
                $errors['database'] = "Fehler beim Speichern der Daten.";
            }
        }
    }
}

// Teams und Positionen aus der Datenbank abrufen
$teams = getTeams($pdo);
$positions = getPositions($pdo);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fußballer-Registrierung - Team und Rollen</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Fußballer-Registrierung</h1>
            <p>Bitte fülle das Formular aus, um dich als Spieler zu registrieren.</p>
        </header>
        
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="success">
                <?php 
                    echo $_SESSION['success_message']; 
                    unset($_SESSION['success_message']); 
                ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($errors['database'])): ?>
            <div class="error"><?php echo $errors['database']; ?></div>
        <?php endif; ?>
        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="registration-form">
            <fieldset>
                <legend>Team und Position</legend>
                
                <div class="form-row">
                    <label for="team">Wähle deine Mannschaft:</label>
                    <select id="team" name="team">
                        <option value="">-- Bitte auswählen --</option>
                        <?php foreach ($teams as $team): ?>
                            <option value="<?php echo $team['team_id']; ?>" <?php echo (isset($formData['team']) && $formData['team'] == $team['team_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($team['team_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['team'])): ?>
                        <div class="error" id="team-error"><?php echo $errors['team']; ?></div>
                    <?php else: ?>
                        <div class="error" id="team-error" style="display: none;"></div>
                    <?php endif; ?>
                    
                    <button type="button" class="toggle-form" id="toggle-new-team">+ Neue Mannschaft hinzufügen</button>
                    
                    <div id="new-team-container" class="new-team-container" <?php echo isset($errors['new_team']) ? 'style="display: block;"' : ''; ?>>
                        <div class="team-container">
                            <input type="text" name="new_team" class="team-input" placeholder="Name der neuen Mannschaft">
                            <button type="submit" name="add_team" class="add-button">Hinzufügen</button>
                        </div>
                        <?php if (isset($errors['new_team'])): ?>
                            <div class="error"><?php echo $errors['new_team']; ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="form-row">
                    <label for="position">Wähle deine Position:</label>
                    <select id="position" name="position">
                        <option value="">-- Bitte auswählen --</option>
                        <?php foreach ($positions as $position): ?>
                            <option value="<?php echo $position['position_id']; ?>" <?php echo (isset($formData['position']) && $formData['position'] == $position['position_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($position['position_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['position'])): ?>
                        <div class="error" id="position-error"><?php echo $errors['position']; ?></div>
                    <?php else: ?>
                        <div class="error" id="position-error" style="display: none;"></div>
                    <?php endif; ?>
                </div>
            </fieldset>
            
            <fieldset>
                <legend>Persönliche Daten</legend>
                
                <div class="form-row">
                    <label for="first_name">Vorname:</label>
                    <input type="text" id="first_name" name="first_name" value="<?php echo isset($formData['first_name']) ? htmlspecialchars($formData['first_name']) : ''; ?>">
                    <?php if (isset($errors['first_name'])): ?>
                        <div class="error"><?php echo $errors['first_name']; ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="form-row">
                    <label for="last_name">Nachname:</label>
                    <input type="text" id="last_name" name="last_name" value="<?php echo isset($formData['last_name']) ? htmlspecialchars($formData['last_name']) : ''; ?>">
                    <?php if (isset($errors['last_name'])): ?>
                        <div class="error"><?php echo $errors['last_name']; ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="form-row">
                    <label for="address">Adresse:</label>
                    <input type="text" id="address" name="address" value="<?php echo isset($formData['address']) ? htmlspecialchars($formData['address']) : ''; ?>">
                    <?php if (isset($errors['address'])): ?>
                        <div class="error"><?php echo $errors['address']; ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="form-row">
                    <label for="email">E-Mail-Adresse:</label>
                    <input type="email" id="email" name="email" value="<?php echo isset($formData['email']) ? htmlspecialchars($formData['email']) : ''; ?>">
                    <?php if (isset($errors['email'])): ?>
                        <div class="error"><?php echo $errors['email']; ?></div>
                    <?php endif; ?>
                </div>
            </fieldset>
            
            <div class="submit-container">
                <button type="submit" name="submit">Formular absenden</button>
            </div>
        </form>
    </div>
    
    <script src="script.js"></script>
</body>
</html>