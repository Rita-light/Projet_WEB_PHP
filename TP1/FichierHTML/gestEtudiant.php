<?php
require_once '../FichierPHP/verifierConnexionEnseignant.php'
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion des Associations</title>
  <link rel="stylesheet" href="../FichierCSS/gestion.css">
 
</head>
<body>
  <header>
    <h1>Gestion des Étudiants</h1>
  </header>

  <main>
    <h1>Bienvenue, Coordonnateur</h1>
    <p>Sélectionnez une option pour gérer les étudiants :</p>
    <a href="enseignant.php">Acceuil</a>
    <a href="gestIncrireEtudiant.php">Inscription de l'étudiant</a>
    <a href="gestAfficheEtudiant.php">Afficher</a>
  </main>
</body>
</html>