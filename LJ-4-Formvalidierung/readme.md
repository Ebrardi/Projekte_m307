Formvalidierung - Lernjob Modul 307

Projektbeschreibung
Dieses Projekt wurde im Rahmen des Moduls 307 "Interaktive Website mit Formular ausfüllen" erstellt. Es handelt sich um eine einfache Formularvalidierung, die vollständig im Browser und ohne Webserver funktioniert.
Implementierte Funktionen siehe hier unten:

1. Basis-Eingabefelder

- Einfache Textfelder für Vorname und Nachname
- Verwendung von type="text" mit entsprechenden name-Attributen
- Platzhaltertexte zur besseren Benutzerführung

2. Spezielle Eingabetypen

- Geburtsdatum mit type="date" für die automatische Datumsvalidierung
- E-Mail mit type="email" für die Validierung des E-Mail-Formats
- Mobilnummer mit type="tel" und einem Pattern für die Formatvalidierung

3. Auswahlmöglichkeiten

- Radio-Buttons für die Geschlechtsauswahl (nur eine Auswahl möglich)
- Dropdown-Liste für die Anrede als Alternative
- Kombinierte Auswahl mit <datalist>, die sowohl vordefinierte Optionen bietet, als auch freie Eingabe ermöglicht

Hier zur technische Umsetzung mit Visual Studio Code

- HTML5 für die Struktur und native Validierung
- CSS3 für das Styling
- Responsive Design für verschiedene Bildschirmgrössen
- Gradient-Hintergrund und moderne UI-Elemente
- Getrennte HTML- und CSS-Dateien für bessere Wartbarkeit

Browser-Validierung
Die Validierung erfolgt vollständig im Browser durch HTML5-Attribute:

required für Pflichtfelder:
- type="email" für die E-Mail-Validierung
- type="date" für die Datumsvalidierung
- pattern="[0-9\s]+" für die Validierung der Telefonnummer
(nur Zahlen und Leerzeichen)

Projektstuktur(Files)

- index.html: Enthält die Formularstruktur und alle Eingabefelder
- styles.css: Enthält alle Styling-Informationen

Testen
Das Formular kann lokal getestet werden, indem die HTML-Datei im Browser geöffnet wird.
