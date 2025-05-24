<?php
    require_once(__DIR__ . '/../FichierPHP/verifierConnexion.php'); 
    require_once(__DIR__ . '/../FichierPHP/recupererCoursEtudiant.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Cours</title>
    <link rel="stylesheet" href="../FichierCSS/styles.css">
    <link rel="stylesheet" href="../FichierCSS/etudiant.css">
</head>
<body>
<header>
    <h1>Mes Cours</h1>
</header>

<div class="sidebar">
    <nav>
        <a href="acceuil.php">Accueil</a>
        <a href="etudiantProfile.php">Profil</a>
        <a href="../FichierPHP/logout.php">Déconnexion</a>
    </nav>
</div>

<main>
    <h2>Liste des cours</h2>
    <?php if (empty($coursEtudiant)): ?>
        <p>Vous n'êtes inscrit à aucun cours.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom du cours</th>
                    <th>Description</th>
                    <th>Département</th>
                    <th>Groupe</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($coursEtudiant as $index => $cours): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo htmlspecialchars($cours['NomCours']); ?></td>
                        <td><?php echo htmlspecialchars($cours['Description']); ?></td>
                        <td><?php echo htmlspecialchars($cours['Departement']); ?></td>
                        <td><?php echo htmlspecialchars($cours['Groupe']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</main>

<footer>
    &copy; 2025 Université Numérique
</footer>
</body>
</html>