<?php
require_once '../FichierPHP/verifierConnexion.php'; // Vérification session active
require_once '../FichierPHP/recupererProfilEtudiant.php'; // Inclure le fichier de récupération

// Assurez-vous que $etudiant est défini via recuperer_profil_etudiant.php
if (!isset($etudiant) || !$etudiant) {
    die("Erreur : Impossible de charger les informations de l'étudiant.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil Étudiant</title>
    <link rel="stylesheet" href="../FichierCSS/styles.css">
    <link rel="stylesheet" href="../FichierCSS/etudiant.css">
</head>
<body>
<header>
    <h1>Profil Étudiant</h1>
</header>

<div class="sidebar">
    <nav>
        <a href="acceuil.php">Accueil</a>
        <a href="etudiantCours.php">Mes cours</a>
        <a href="../FichierPHP/logout.php">Déconnexion</a>
    </nav>
</div>

<main>
    <h2>Modifier vos informations</h2>
    <form method="POST" action="../FichierPHP/modifierProfileEtudiant.php" enctype="multipart/form-data">
        <label>Nom :</label>
        <input type="text" name="nom" value="<?php echo htmlspecialchars($etudiant['Nom']); ?>" required><br>
        
        <label>Prénom :</label>
        <input type="text" name="prenom" value="<?php echo htmlspecialchars($etudiant['Prenom']); ?>" required><br>
        
        <label>Email :</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($etudiant['Email']); ?>" required><br>
        
        <label>Date de naissance :</label>
        <input type="date" name="dateNaissance" value="<?php echo htmlspecialchars($etudiant['DateNaissance']); ?>" required><br>

        <label>Avatar actuel :</label><br>
        <img src="<?php echo htmlspecialchars($etudiant['Avatar']?? '', ENT_QUOTES) ; ?>" alt="Avatar de l'étudiant" width="100"><br>
       

        <label>Avatar :</label>
        <input type="file" name="avatar"><br>
        
        <input type="submit" value="Enregistrer les modifications">
    </form>
</main>

<footer>
    &copy; 2025 Université Numérique
</footer>
</body>
</html>