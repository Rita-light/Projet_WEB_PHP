<?php
require_once '../FichierPHP/verifierConnexionEnseignant.php';
require_once '../FichierPHP/gestGroupeProfesseur.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion Groupes-Professeurs</title>
  <link rel="stylesheet" href="../FichierCSS/style2.css">
</head>
<body>
  <header>
    <h1>Gérer les Associations Groupes-Professeurs</h1>
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
          <th>Nom de l’Enseignant</th>
        </tr>
      </thead>
      <tbody>
        <?php afficherAssociations($dbConnection, $departementId); ?>
      </tbody>
    </table>

    <h2>Ajouter une Association</h2>
    <form method="POST" action="../FichierPHP/gestGroupeProfesseur.php">
      <label for="groupe">Groupe :</label>
      <select name="groupe" id="groupe" required>
        <?php afficherGroupes($dbConnection, $departementId); ?>
      </select>
      
      <label for="enseignant">Enseignant :</label>
      <select name="enseignant" id="enseignant" required>
        <?php afficherProfesseurs($dbConnection, $departementId); ?>
      </select>

      <input type="submit" value="Ajouter">
    </form>

  </main>
</body>
</html>