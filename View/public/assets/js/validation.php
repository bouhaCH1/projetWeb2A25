<?php
header('Content-Type: application/javascript; charset=UTF-8');
?>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('missionForm');
    if (!form) return;

    // Validation en temps reel
    document.getElementById('titre').addEventListener('input', function () {
        validateTitre();
    });
    document.getElementById('budget').addEventListener('input', function () {
        validateBudget();
    });
    document.getElementById('description').addEventListener('input', function () {
        validateDescription();
    });
    document.getElementById('date_debut').addEventListener('change', function () {
        validateDates();
    });
    document.getElementById('date_fin').addEventListener('change', function () {
        validateDates();
    });
    document.getElementById('statut').addEventListener('change', function () {
        validateStatut();
    });
    document.getElementById('competences').addEventListener('input', function () {
        validateCompetences();
    });

    // Validation a la soumission
    form.addEventListener('submit', function (e) {
        let valid = true;
        if (!validateTitre()) valid = false;
        if (!validateBudget()) valid = false;
        if (!validateDescription()) valid = false;
        if (!validateDates()) valid = false;
        if (!validateStatut()) valid = false;
        if (!validateCompetences()) valid = false;
        if (!valid) e.preventDefault();
    });

    // ---- Fonctions de validation ----

    function showError(fieldId, message) {
        const field = document.getElementById(fieldId);
        const error = document.getElementById('err-' + fieldId);
        field.classList.add('is-invalid');
        field.classList.remove('is-valid');
        if (error) error.textContent = message;
        return false;
    }

    function showSuccess(fieldId) {
        const field = document.getElementById(fieldId);
        const error = document.getElementById('err-' + fieldId);
        field.classList.remove('is-invalid');
        field.classList.add('is-valid');
        if (error) error.textContent = '';
        return true;
    }

    function validateTitre() {
        const val = document.getElementById('titre').value.trim();
        if (val === '')
            return showError('titre', 'Le titre est obligatoire.');
        if (val.length < 5)
            return showError('titre', 'Le titre doit contenir au moins 5 caracteres.');
        if (val.length > 100)
            return showError('titre', 'Le titre ne doit pas depasser 100 caracteres.');
        return showSuccess('titre');
    }

    function validateBudget() {
        const val = document.getElementById('budget').value.trim();
        if (val === '')
            return showError('budget', 'Le budget est obligatoire.');
        if (isNaN(val) || Number(val) <= 0)
            return showError('budget', 'Le budget doit etre un nombre positif.');
        if (Number(val) > 1000000)
            return showError('budget', 'Le budget ne peut pas depasser 1 000 000 EUR.');
        return showSuccess('budget');
    }

    function validateDescription() {
        const val = document.getElementById('description').value.trim();
        if (val === '')
            return showError('description', 'La description est obligatoire.');
        if (val.length < 20)
            return showError('description', 'La description doit contenir au moins 20 caracteres. (' + val.length + '/20)');
        return showSuccess('description');
    }

    function validateDates() {
        const debut = document.getElementById('date_debut').value;
        const fin = document.getElementById('date_fin').value;
        let valid = true;

        if (debut === '') {
            showError('date_debut', 'La date de debut est obligatoire.');
            valid = false;
        } else {
            showSuccess('date_debut');
        }

        if (fin === '') {
            showError('date_fin', 'La date de fin est obligatoire.');
            valid = false;
        } else if (debut !== '' && fin <= debut) {
            showError('date_fin', 'La date de fin doit etre apres la date de debut.');
            valid = false;
        } else {
            showSuccess('date_fin');
        }

        return valid;
    }

    function validateStatut() {
        const val = document.getElementById('statut').value;
        if (val === '')
            return showError('statut', 'Veuillez choisir un statut.');
        return showSuccess('statut');
    }

    function validateCompetences() {
        const val = document.getElementById('competences').value.trim();
        if (val === '')
            return showError('competences', 'Les competences sont obligatoires.');
        if (val.length < 3)
            return showError('competences', 'Entrez au moins une competence.');
        return showSuccess('competences');
    }
});
