<?php
require_once '../FichierPHP/verifierConnexionEnseignant.php'; // Vérification de connexion
require_once '../FichierPHP/listeGroupe.php'; // Récupération des groupes
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Étudiants par Groupe</title>
    <link rel="stylesheet" href="../FichierCSS/styles.css">
    <link rel="stylesheet" href="../FichierCSS/enseignant.css">
    <style>
          
    .form-container {
      margin-bottom: 20px;
      background-color: white;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    label {
      font-weight: bold;
      color: #FF69B4;
    }

    select,
    input[type="submit"] {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
      border-radius: 5px;
      border: 1px solid #87CEEB;
      box-sizing: border-box;
      font-size: 16px;
    }

    input[type="submit"] {
      background-color: #ff69b4b5;
      color: white;
      border: none;
      cursor: pointer;
      font-weight: bold;
      transition: background-color 0.3s;
    }

    input[type="submit"]:hover {
      background-color: #FF1493;
    }

    .table-container {
      margin-top: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      border: 1px solid #87CEEB;
      background-color: white;
    }

    th, td {
      text-align: left;
      padding: 10px;
      border-bottom: 1px solid #87CEEB;
    }

    th {
      background-color: #3eb4ead5;
      color: white;
    }

    td {
      color: #000;
    }
    </style>
</head>
<body>
<header>
    <h1>Liste des Étudiants par Groupe</h1>
</header>
<div class="sidebar">
    <nav>
        <a href="enseignant.php">Accueil</a>
        <a href="enseignatProfile.php">Profil</a>
        <a href="enseignantCours.php">Mes Cours</a>
        <?php if (isset($_SESSION['is_coordonnateur']) && $_SESSION['is_coordonnateur']): ?>
            <a href="gestionCours.php">Gérer les cours</a>
            <a href="gestEtudiant.php">Gérer les Étudiants</a>
        <?php endif; ?>
        <a href="../FichierPHP/logout.php">Déconnexion</a>
    </nav>
</div>

<main>
    <!-- Sélection des groupes -->
    <div class="form-container">
        <h2>Choisissez un groupe</h2>
        <form method="POST" action="listeEtudiant.php">
            <label for="coursSelect">Numéro du groupe :</label>
            <select id="coursSelect" name="cours" required>
                <option value="">-- Sélectionnez un groupe --</option>
                <?php foreach ($groupes as $groupe): ?>
                    <option value="<?php echo htmlspecialchars($groupe['NumeroGroupe']); ?>">
                        <?php echo htmlspecialchars($groupe['NomGroupe']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Afficher les étudiants">
        </form>
    </div>

    <!-- Affichage des étudiants -->
    <div class="table-container">
        <h2>Liste des étudiants</h2>
        <table>
            <thead>
                <tr>
                    <th>Numéro DA</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php include '../FichierPHP/afficherEtudiant.php'; ?>
            </tbody>
        </table>
    </div>
</main>

<footer>
    &copy; 2025 Université Numérique
</footer>
</body>
</html>