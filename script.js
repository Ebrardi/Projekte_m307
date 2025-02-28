// JavaScript für interaktive Elemente
document.addEventListener('DOMContentLoaded', function() {
    // Toggle für das neue Team-Formular
    const toggleButton = document.getElementById('toggle-new-team');
    const newTeamContainer = document.getElementById('new-team-container');
    
    if (toggleButton) {
        toggleButton.addEventListener('click', function() {
            if (newTeamContainer.style.display === 'block') {
                newTeamContainer.style.display = 'none';
            } else {
                newTeamContainer.style.display = 'block';
            }
        });
    }
    
    // Formularvalidierung
    const registrationForm = document.getElementById('registration-form');
    if (registrationForm) {
        registrationForm.addEventListener('submit', function(event) {
            let hasErrors = false;
            
            // Team-Validierung
            const teamSelect = document.getElementById('team');
            if (teamSelect && teamSelect.value === '') {
                document.getElementById('team-error').textContent = 'Bitte wähle eine Mannschaft aus.';
                document.getElementById('team-error').style.display = 'block';
                hasErrors = true;
            } else if (teamSelect) {
                document.getElementById('team-error').style.display = 'none';
            }
            
            // Position-Validierung
            const positionSelect = document.getElementById('position');
            if (positionSelect && positionSelect.value === '') {
                document.getElementById('position-error').textContent = 'Bitte wähle eine Position aus.';
                document.getElementById('position-error').style.display = 'block';
                hasErrors = true;
            } else if (positionSelect) {
                document.getElementById('position-error').style.display = 'none';
            }
            
            // Client-seitige Validierung verhindert Submit bei Fehlern
            if (hasErrors) {
                event.preventDefault();
            }
        });
    }
});