<?php
require_once '../FichierPHP/verifierConnexion.php'
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
    <h1>Gestion des Associations</h1>
  </header>

  <main>
    <h1>Bienvenue, Coordonnateur</h1>
    <p>Sélectionnez une option pour gérer les associations dans votre département :</p>
    <a href="acceuil.php">Acceuil</a>
    <a href="gestion_cours_enseignant.php">Gérer les Cours-Enseignants</a>
    <a href="gestion_groupe_professeur.php">Gérer les Groupes-Professeurs</a>
    <a href="gestion_groupe_etudiant.php">Gérer les Groupes-Étudiants</a>
  </main>
</body>
</html>