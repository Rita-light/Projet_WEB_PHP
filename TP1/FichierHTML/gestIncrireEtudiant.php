<?php
require_once(__DIR__ . '/../FichierPHP/verifierConnexion.php');
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
    <a href="gestEtudiant.php">Retour</a>
</nav>
<main>
    <h2>Incrire un étudiant</h2>
    <form method="POST" action="../FichierPHP/gestionEtudiant.php" enctype="multipart/form-data"> 
        <input type="hidden" name="operation" value="<?php echo isset($etudiant) ? 'modifier' : 'inscrire'; ?>">
        <label for="">Nom : </label>
        <input type="text" name="nom" required placeholder="Nom">
        <label for="">Prénom : </label>
        <input type="text" name="prenom" required placeholder="Prénom">
        <label for="">Date de naissance : </label>
        <input type="date" name="dateNaissance" required placeholder="Date de naissance">
        <label for="">Email : </label>
        <input type="email" name="email" required placeholder="Email">
        <label for="">Mot de passe : </label>
        <input type="password" name="password" required placeholder="Mot de passe">
        <label for="">Avatar : </label>
        <input type="file" name="avatar" accept="image/*" >
        <button type="submit">Inscrire l'Étudiant</button>
    </form>
</main>

</body>
</html>