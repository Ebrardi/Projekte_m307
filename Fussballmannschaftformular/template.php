<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fussball-Registrierungssystem</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Fussball-Registrierungssystem</h1>
        
        <?php if ($successMessage): ?>
            <div class="success-message">
                <?php echo $successMessage; ?>
            </div>
        <?php endif; ?>
        
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <fieldset>
                <legend>Team- und Positionsinformationen</legend>
                
                <div class="form-group">
                    <label for="team_id">Mannschaft:</label>
                    <div class="team-selection">
                        <select name="team_id" id="team_id">
                            <option value="">-- Mannschaft auswählen --</option>
                            <?php foreach ($teams as $team): ?>
                                <option value="<?php echo $team['id']; ?>" <?php echo ($formData['team_id'] == $team['id']) ? 'selected' : ''; ?>>
                                    <?php echo $team['team_name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="button" class="add-team-btn" onclick="toggleNewTeamField()">+ Neue Mannschaft</button>
                    </div>
                    <div class="add-team-field" id="add_team_field">
                        <label for="new_team">Neue Mannschaft:</label>
                        <input type="text" name="new_team" id="new_team" value="<?php echo $formData['new_team']; ?>">
                    </div>
                    <?php if (isset($errors['team'])): ?>
                        <div class="error-message"><?php echo $errors['team']; ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="position">Position:</label>
                    <select name="position" id="position">
                        <option value="">-- Position auswählen --</option>
                        <?php foreach ($positions as $position): ?>
                            <option value="<?php echo $position; ?>" <?php echo ($formData['position'] == $position) ? 'selected' : ''; ?>>
                                <?php echo $position; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['position'])): ?>
                        <div class="error-message"><?php echo $errors['position']; ?></div>
                    <?php endif; ?>
                </div>
            </fieldset>
            
            <fieldset>
                <legend>Persönliche Daten</legend>
                
                <div class="form-group">
                    <label for="full_name">Vorname & Name:</label>
                    <input type="text" name="full_name" id="full_name" value="<?php echo $formData['full_name']; ?>">
                    <?php if (isset($errors['full_name'])): ?>
                        <div class="error-message"><?php echo $errors['full_name']; ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="form-group address-container">
                    <label>Adresse:</label>
                    <div class="address-fields">
                        <div class="address-row">
                            <div class="street-field">
                                <label for="street">Strasse:</label>
                                <input type="text" name="street" id="street" value="<?php echo $formData['street']; ?>">
                                <?php if (isset($errors['street'])): ?>
                                    <div class="error-message"><?php echo $errors['street']; ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="house-number-field">
                                <label for="house_number">Nummer:</label>
                                <input type="text" name="house_number" id="house_number" value="<?php echo $formData['house_number']; ?>">
                                <?php if (isset($errors['house_number'])): ?>
                                    <div class="error-message"><?php echo $errors['house_number']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="address-row">
                            <div class="postal-code-field">
                                <label for="postal_code">Postleitzahl:</label>
                                <input type="text" name="postal_code" id="postal_code" value="<?php echo $formData['postal_code']; ?>">
                                <?php if (isset($errors['postal_code'])): ?>
                                    <div class="error-message"><?php echo $errors['postal_code']; ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="city-field">
                                <label for="city">Stadt:</label>
                                <input type="text" name="city" id="city" value="<?php echo $formData['city']; ?>">
                                <?php if (isset($errors['city'])): ?>
                                    <div class="error-message"><?php echo $errors['city']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="email">E-Mail-Adresse:</label>
                    <input type="email" name="email" id="email" value="<?php echo $formData['email']; ?>">
                    <?php if (isset($errors['email'])): ?>
                        <div class="error-message"><?php echo $errors['email']; ?></div>
                    <?php endif; ?>
                </div>
            </fieldset>
            
            <button type="submit">Registrieren</button>
        </form>
        
        <div class="registered-players">
            <h2>Registrierte Spieler</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Team</th>
                        <th>Position</th>
                        <th>Adresse</th>
                        <th>E-Mail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($players) > 0): ?>
                        <?php foreach ($players as $player): ?>
                            <tr>
                                <td><?php echo $player['full_name']; ?></td>
                                <td><?php echo $player['team_name']; ?></td>
                                <td><?php echo $player['position']; ?></td>
                                <td>
                                    <?php echo $player['street'] . ' ' . $player['house_number']; ?><br>
                                    <?php echo $player['postal_code'] . ' ' . $player['city']; ?>
                                </td>
                                <td><?php echo $player['email']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5">Noch keine Spieler registriert.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <script src="script.js"></script>
</body>
</html>