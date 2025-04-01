<?php
require_once '../FichierPHP/verifierConnexionEnseignant.php'; // Vérifie si l'enseignant est connecté
require_once '../FichierPHP/recupererCoursEnseignant.php'; // Récupère les données
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes cours et groupes</title>
    <link rel="stylesheet" href="../FichierCSS/styles.css">
    <link rel="stylesheet" href="../FichierCSS/enseignant.css">
    <style>
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .card {
            border: 1px solid #87CEEB;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background-color: white;
        }
        .card-header {
            background-color:rgba(53, 163, 241, 0.74);
            color: white;
            padding: 10px;
            font-size: 18px;
            font-weight: bold;
        }
        .card-body {
            padding: 15px;
        }
        .group-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .group-list li {
            padding: 5px 0;
            border-bottom: 1px solid #F0F8FF;
        }
        .group-list li:last-child {
            border-bottom: none;
        }
      </style>
</head>
<body>
<header>
    <h1>Mes Cours et Groupes</h1>
</header>

<div class="sidebar">
    <nav>
        <a href="enseignant.php">Accueil</a>
        <a href="enseignatProfile.php">Profil</a>
        <a href="listeEtudiant.php">Listes étudiants</a>
        <?php if (isset($_SESSION['is_coordonnateur']) && $_SESSION['is_coordonnateur']): ?>
            <a href="gestionCours.php">Gérer les cours</a>
        <?php endif; ?>
        <a href="../FichierPHP/logout.php">Déconnexion</a>
    </nav>
</div>

<main>
    <h1>Cours enseignés</h1>
    <div class="grid-container">
        <?php if (empty($coursEtGroupes)): ?>
            <p>Aucun cours assigné.</p>
        <?php else: ?>
            <?php 
            $coursActuel = null;
            $groupesCours = [];

            foreach ($coursEtGroupes as $cours) {
                // Nouveau cours
                if ($cours['NomCours'] !== $coursActuel) {
                    if ($coursActuel !== null) {
                        // Affiche les groupes du cours précédent
                        echo "
                        <ul class='group-list'>
                            " . implode('', array_map(fn($groupe) => "<li>$groupe</li>", $groupesCours)) . "
                        </ul>
                        </div></div>";
                    }

                    // Réinitialise pour le nouveau cours
                    $coursActuel = $cours['NomCours'];
                    $groupesCours = [];
                    echo "
                    <div class='card'>
                        <div class='card-header'>{$cours['NomCours']}</div>
                        <div class='card-body'>
                            <p><strong>Description :</strong> {$cours['Description']}</p>
                            <p><strong>Groupes associés :</strong></p>";
                }

                // Ajoute les groupes associés
                $groupesCours[] = $cours['NumeroGroupe'] ?? 'Pas de groupe';
            }

            // Affiche les groupes du dernier cours
            echo "
            <ul class='group-list'>
                " . implode('', array_map(fn($groupe) => "<li>$groupe</li>", $groupesCours)) . "
            </ul>
            </div></div>";
            ?>
        <?php endif; ?>
    </div>
</main>

<footer>
    &copy; 2025 Université Numérique
</footer>
</body>
</html>