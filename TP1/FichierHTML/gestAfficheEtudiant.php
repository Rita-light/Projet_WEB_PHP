<?php
require_once '../FichierPHP/verifierConnexion.php'; 
require_once '../FichierPHP/gestionEtudiant.php'; 

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Étudiants</title>
    <link rel="stylesheet" href="../FichierCSS/style2.css">
</head>
<header>
    <h1>Gérer les étudians</h1>
</header>
<nav>
    <a href="gestEtudiant.php">Retour</a>
</nav>
<body>
    <main>
        <h2>Listes des etudiants</h2>
        <table border='1'>
                <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>Numéro DA</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Date de Naissance</th>
                        <th>Email</th>
                        <th>Date d'inscription</th>
                        <th>Opérations</th>
                    </tr>
                </thead>
                <tbody>
                    <?php afficherEtudiants($dbConnection); ?>
                </tbody>
        </table>
    </main>
</body>
</html>
