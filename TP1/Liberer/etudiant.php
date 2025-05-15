<?php
require_once '../FichierPHP/verifierConnexionEtudiant.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Accueil Étudiant</title>
  <link rel="stylesheet" href="../FichierCSS/styles.css">
  <link rel="stylesheet" href="../FichierCSS/etudiant.css">
</head>
<body>
  <header>
    Bienvenue dans la plateforme Étudiante
  </header>

  <div class="sidebar">
    <nav>
      <a href="etudiantProfile.php">Profil</a>
      <a href="etudiantCours.php">Mes cours</a>
      <a href="../FichierPHP/logout.php">Deconnexion</a>
    </nav>
  </div>

  <main>
    <h1>Bonjour <?php echo htmlspecialchars($_SESSION['user_name']); ?></h1>
    <p>Voici votre tableau de bord étudiant. Vous pouvez consulter vos cours et vos notes ici.</p>
  </main>

  <footer>
    &copy; 2025 Université Numérique
  </footer>
</body>
</html>
