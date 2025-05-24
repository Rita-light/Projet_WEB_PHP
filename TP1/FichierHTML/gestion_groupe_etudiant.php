<?php
require_once(__DIR__ . '/../FichierPHP/verifierConnexion.php');
require_once(__DIR__ . '/../FichierPHP/gestGroupeEtudiant.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion Groupes-Étudiants</title>
    <link rel="stylesheet" href="../FichierCSS/style2.css">
</head>
<body>
<header>
    <h1>Gérer les Associations Groupes-Étudiants</h1>
</header>
<nav>
    <a href="gestionCours.php">Retour</a>
</nav>

<main>
    <h2>Liste des Associations</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Nom du Groupe</th>
                <th>Nom de l’Étudiant</th>
            </tr>
        </thead>
        <tbody>
            <?php afficherAssociations($dbConnection, $departementId); ?>
        </tbody>
    </table>

    <h2>Ajouter un Étudiant à un Groupe</h2>
    <form method="POST" action="../FichierPHP/gestGroupeEtudiant.php">
        <label for="groupe">Groupe :</label>
        <select name="groupe" id="groupe" required>
            <option value="">-- Sélectionnez un Groupe --</option>
            <?php afficherGroupes($dbConnection, $departementId); ?>
        </select>

        <label for="etudiant">Étudiant :</label>
        <select name="etudiant" id="etudiant" required>
            <option value="">-- Sélectionnez un Étudiant --</option>
            <!-- Cette liste sera remplie dynamiquement via JavaScript -->
        </select>

        <input type="submit" value="Ajouter">
    </form>

    <script>
        document.getElementById('groupe').addEventListener('change', function () {
            const groupeId = this.value;

            // Réinitialiser la liste des étudiants
            const etudiantSelect = document.getElementById('etudiant');
            etudiantSelect.innerHTML = '<option value="">-- Chargement... --</option>';

            if (groupeId !== '') {
                fetch('../FichierPHP/getEtudiantsParCours.php?idGroupe=' + encodeURIComponent(groupeId))
                    .then(response => response.json())
                    .then(data => {
                        etudiantSelect.innerHTML = '<option value="">-- Sélectionnez un Étudiant --</option>';
                        data.forEach(etudiant => {
                            const option = document.createElement('option');
                            option.value = etudiant.ID;
                            option.textContent = etudiant.Nom + ' ' + etudiant.Prenom;
                            etudiantSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        etudiantSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                        console.error('Erreur:', error);
                    });
            } else {
                etudiantSelect.innerHTML = '<option value="">-- Sélectionnez un Étudiant --</option>';
            }
        });
    </script>
</main>
</body>
</html>