<?php
  require_once '../FichierPHP/verifierConnexionEnseignant.php'; 
  require_once '../FichierPHP/recupererProfilEnseignant.php'; 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil Enseignant</title>
    <link rel="stylesheet" href="../FichierCSS/styles.css">
    <link rel="stylesheet" href="../FichierCSS/enseignant.css">
    <style>

      form {
        display: flex;
        flex-direction: column;
        gap: 15px;
      }

      label {
        font-weight: bold;
        color: #FF69B4;
      }

      input[type="text"],
      input[type="email"],
      input[type="date"],
      input[type="password"],
      input[type="file"],
      input[type="submit"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #87CEEB;
        border-radius: 5px;
        box-sizing: border-box;
        font-size: 16px;
      }

      input[type="checkbox"] {
        margin-right: 10px;
      }

      input[type="submit"] {
        background-color: #FF69B4;
        color: white;
        border: none;
        cursor: pointer;
        font-weight: bold;
        transition: background-color 0.3s;
      }

      input[type="submit"]:hover {
        background-color: #FF1493;
      }
    </style>
</head>
<body>
<header>
    <h1>Profil Enseignant</h1>
</header>

<div class="sidebar">
    <nav>
        <a href="enseignant.php">Accueil</a>
        <a href="enseignantCours.php">Mes cours</a>
        <a href="listeEtudiant.php">Liste Étudiants</a>
        <?php if (isset($_SESSION['is_coordonnateur']) && $_SESSION['is_coordonnateur']): ?>
            <a href="gestionCours.php">Gérer les cours</a>
            <a href="gestEtudiant.php">Gérer les Étudiants</a>
        <?php endif; ?>
        <a href="../FichierPHP/logout.php">Déconnexion</a>
    </nav>
</div>

<main>
    <h2>Modifier vos informations</h2>
    <form method="POST" action="../FichierPHP/modifierProfilEnseignant.php">
        <label>Nom :</label>
        <input type="text" name="nom" value="<?php echo htmlspecialchars($enseignant['Nom']); ?>" required>

        <label>Prénom :</label>
        <input type="text" name="prenom" value="<?php echo htmlspecialchars($enseignant['Prenom']); ?>" required>

        <label>Email :</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($enseignant['Email']); ?>" required>

        <label>Date de naissance :</label>
        <input type="date" name="dateNaissance" value="<?php echo htmlspecialchars($enseignant['DateNaissance']); ?>" required>

        <label>Date d'embauche :</label>
        <input type="date" name="dateEmbauche" value="<?php echo htmlspecialchars($enseignant['DateEmbauche']); ?>" required>

        <label>Département :</label>
        <input type="text" name="departement" value="<?php echo htmlspecialchars($enseignant['Departement']); ?>" readonly>

        <label>Coordonnateur :</label>
        <input type="checkbox" name="coordonnateur" <?php echo $enseignant['Coordonnateur'] ? 'checked' : ''; ?>>

        <label>Avatar :</label>
        <input type="file" name="avatar">

        <input type="submit" value="Enregistrer les modifications">
    </form>
</main>

<footer>
    &copy; 2025 Université Numérique
</footer>
</body>
</html>