Fussball-Registrierungssystem
Ein interaktives Webformular zum Registrieren von Fussballspielern, entwickelt für das Modul 307.
Installation

Platzieren Sie alle Dateien in Ihrem MAMP-Webserver-Verzeichnis.
Erstellen Sie eine neue Datenbank in phpMyAdmin:

Name: football_registration
Oder importieren Sie die setup.sql-Datei


Passen Sie falls nötig die Verbindungsdaten in config.php an:

Standardmässig: Benutzer root, Passwort root



Dateien im Projekt

index.php: Hauptdatei, die die Anwendungslogik enthält
config.php: Datenbankverbindungskonfiguration
functions.php: Hilfsfunktionen für die Anwendung
template.php: HTML-Template für die Benutzeroberfläche
styles.css: CSS-Styling für das Design
script.js: JavaScript für interaktive Funktionen
setup.sql: SQL-Befehle zum Einrichten der Datenbank

Funktionen

Auswahl oder Hinzufügen von Fussballmannschaften
Auswahl der Spielerposition
Eingabe persönlicher Daten (Name, Adresse, E-Mail)
Validierung der Eingabenx^x
Speicherung in der Datenbank
Anzeige der letzten 10 registrierten Spieler

Technische Details

Verwendet das POST/Redirect/GET-Prinzip zur Vermeidung doppelter Einträge
Formularvalidierung mit Fehleranzeige
Beibehaltung der eingegebenen Daten bei Validierungsfehlern
Schutz vor SQL-Injection durch vorbereitete Anweisungen
Responsive Design für verschiedene Bildschirmgrößen