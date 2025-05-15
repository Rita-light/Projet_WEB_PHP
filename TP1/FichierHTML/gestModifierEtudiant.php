<?php
require_once '../FichierPHP/verifierConnexion.php'; 
require_once '../config/db.php';
require_once '../Classes/Etudiant.php'; // Inclusion de la classe Etudiant

// Vérifier si le NumeroDA est passé dans l'URL
if (isset($_GET['user_id']) && isset($_GET['numeroDA'])) {
    $id = htmlspecialchars($_GET['user_id']);
    $numeroDA = htmlspecialchars($_GET['numeroDA']);

    // Récupérer les données de l'étudiant depuis la base de données
    $etudiant = Etudiant::readByID($dbConnection, $id);

    if (!$etudiant) {
        die("Erreur : Étudiant introuvable.");
    }
} else {
    die("Erreur : Paramètres `user_id` ou `numeroDA` manquants.");
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription Étudiant</title>
    <link rel="stylesheet" href="../FichierCSS/etudiant.css">
    <link rel="stylesheet" href="../FichierCSS/style2.css">
</head>
<body>
<header>
    <h1>Inscription D'Étudiant</h1>
</header>
<nav>
    <a href="gestAfficheEtudiant.php">Retour</a>
</nav>

<main>
    <h2>Modifier vos informations</h2>
    <form method="POST" action="../FichierPHP/gestionEtudiant.php" enctype="multipart/form-data">
         <!-- Champ caché pour indiquer si c'est une inscription ou une modification -->
        <input type="hidden" name="operation" value="<?php echo isset($etudiant) ? 'modifier' : 'inscrire'; ?>">
        <input type="hidden" name="numeroDA" value="<?php echo $numeroDA ?>">
        <input type="hidden" name="user_id" value="<?= htmlspecialchars($_GET['user_id']) ?>">

        <label>Nom :</label>
        <input type="text" name="nom" value="<?php echo htmlspecialchars($etudiant['Nom']); ?>" required><br>
        
        <label>Prénom :</label>
        <input type="text" name="prenom" value="<?php echo htmlspecialchars($etudiant['Prenom']); ?>" required><br>
        
        <label>Email :</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($etudiant['Email']); ?>" required><br>
        
        <label>Date de naissance :</label>
        <input type="date" name="dateNaissance" value="<?php echo htmlspecialchars($etudiant['DateNaissance']); ?>" required><br>

        <label>Avatar :</label>
        <input type="file" name="avatar" ><br>
        
        <input type="submit" value="Enregistrer les modifications">
    </form>
</main>

</body>
</html>