// Funktion zum Ein-/Ausblenden des Feldes für neue Mannschaften
function toggleNewTeamField() {
    const teamField = document.getElementById('add_team_field');
    if (teamField.style.display === 'block') {
        teamField.style.display = 'none';
        document.getElementById('new_team').value = '';
    } else {
        teamField.style.display = 'block';
        document.getElementById('team_id').selectedIndex = 0;
    }
}

// Wenn bereits ein neues Team eingegeben wurde, Feld anzeigen
window.onload = function() {
    if (document.getElementById('new_team').value) {
        document.getElementById('add_team_field').style.display = 'block';
    }
};