<?php
require_once '../FichierPHP/verifierConnexionEnseignant.php';
require_once '../FichierPHP/gestGroupeEtudiant.php';
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
            <?php afficherEtudiants($dbConnection); ?>
        </select>

        <input type="submit" value="Ajouter">
    </form>
</main>
</body>
</html>