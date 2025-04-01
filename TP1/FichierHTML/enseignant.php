<?php
require_once '../FichierPHP/verifierConnexionEnseignant.php'
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Accueil Enseignant</title>
  <link rel="stylesheet" href="../FichierCSS/styles.css">
  <link rel="stylesheet" href="../FichierCSS/enseignant.css">
</head>
<body>
  <header>
    Bienvenue dans l’espace Enseignant
  </header>

  <div class="sidebar" >
    <nav>
      
      <a href="enseignatProfile.php" >Profile</a>
      <a href="enseignantCours.php" >Mes Cours</a>
      <a href="listeEtudiant.php" >Listes Étudiants</a>
      <?php if (isset($_SESSION['is_coordonnateur']) && $_SESSION['is_coordonnateur']): ?>
        <!-- Liens spécifiques aux coordonnateurs -->
        <a href="gestionCours.php">Gérer les cours</a>
        <a href="gestEtudiant.php">Gérer les Étudiants</a>
      <?php endif; ?>
      <a href="../FichierPHP/logout.php">Déconnexion</a>
    </nav>
  </div>

  <main>
    <h1>Bonjour M. <?php echo htmlspecialchars($_SESSION['user_name']); ?></h1>
    <p>Gérez vos cours depuis cette interface.</p>
  </main>

  <footer>
    &copy; 2025 Université Numérique
  </footer>
</body>
</html>
