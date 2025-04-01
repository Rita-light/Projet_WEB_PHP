<?php
require_once '../FichierPHP/verifierConnexionEnseignant.php'
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion des Associations</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #F0F8FF;
    }

    header {
      background-color: #FF69B4;
      color: white;
      text-align: center;
      padding: 15px 0;
    }

    main {
      max-width: 600px;
      margin: 50px auto;
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    h1 {
      color: #000;
    }

    a {
      display: block;
      margin: 15px 0;
      padding: 10px;
      background-color: #87CEEB;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
    }

    a:hover {
      background-color:rgb(80, 186, 228);
    }
  </style>
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