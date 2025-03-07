Fussball-Registrierungssystem

Hier gebe ich einen kurzen Rapport meiner erstellten Datenbank des Moduls 307 - Interaktive Website mit Formular entwickeln.
Hierbei geht es um ein interaktives Webformular zum Registrieren von Fussballspielern.

Installationsvorgang:

Das Platzieren aller Dateien in meinem MAMP-Webserver-Verzeichnis.
Das Erstellen einer neuen Datenbank in phpMyAdmin:

Name: football_registration
Oder setup.sql-Datei importieren


Verbindungsdaten in config.php anpassen(falls nötig):

Standardmässig: Benutzer root, Passwort root



Dateien im Projekt:

- index.php: Hauptdatei, die die Anwendungslogik enthält
- config.php: Datenbankverbindungskonfiguration
- functions.php: Hilfsfunktionen für die Anwendung
- template.php: HTML-Template für die Benutzeroberfläche
- styles.css: CSS-Styling für das Design
- script.js: JavaScript für interaktive Funktionen
- setup.sql: SQL-Befehle zum Einrichten der Datenbank

Funktionen:

- Auswahl oder Hinzufügen von Fussballmannschaften
- Auswahl der Spielerposition
- Eingabe persönlicher Daten (Name, Adresse, E-Mail)
- Validierung der Eingabenx^x
- Speicherung in der Datenbank
- Anzeige der letzten 10 registrierten Spieler

Technische Details:

- Verwendet das POST/Redirect/GET-Prinzip zur Vermeidung doppelter Einträge
- Formularvalidierung mit Fehleranzeige
- Beibehaltung der eingegebenen Daten bei Validierungsfehlern
- Schutz vor SQL-Injection durch vorbereitete Anweisungen
- Responsive Design für verschiedene Bildschirmgrößen
