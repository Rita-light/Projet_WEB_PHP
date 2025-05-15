<?php
require_once '../FichierPHP/verifierConnexion.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Accueil Utilisateur</title>
  <link rel="stylesheet" href="../FichierCSS/styles.css">
  <link rel="stylesheet" href="../FichierCSS/etudiant.css">
</head>
<body>
  <header>
    Bienvenue dans la plateforme <?php echo htmlspecialchars($_SESSION['user_roles'][0]); ?>
  </header>

  <div class="sidebar">
    <nav>
        <?php
        if (!empty($_SESSION['pages_utilisateur'])) {
            foreach ($_SESSION['pages_utilisateur'] as $page) {
                $label = htmlspecialchars($page['label']);
                $url = htmlspecialchars($page['url']);
                echo "<a href='$url'>$label</a>";
            }
        }
        ?>
        <a href="../FichierPHP/logout.php">Deconnexion</a>

    </nav>
  </div>

  <main>
    <h1>Bonjour <?php echo htmlspecialchars($_SESSION['user_name']); ?></h1>
    <p>Voici votre tableau de bord. <br> Vous pouvez consulter vos cours et vos notes ici.</p>
  </main>

  <footer>
    &copy; 2025 Université Numérique
  </footer>
</body>
</html>
