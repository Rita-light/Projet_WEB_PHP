<?php
require_once '../FichierPHP/verifierConnexionEnseignant.php';
require_once '../config/db.php'; // Connexion à la base de données

// Vérifie si un groupe a été sélectionné
if (!isset($_POST['cours']) || empty($_POST['cours'])) {
    echo "<tr><td colspan='4'>Veuillez sélectionner un groupe.</td></tr>";
    return;
}

$numeroGroupe = $_POST['cours']; // Récupère le numéro du groupe sélectionné

try {
    // Récupère les étudiants du groupe sélectionné
    $query = "
        SELECT 
            Etudiant.NumeroDA,
            Etudiant.Nom,
            Etudiant.Prenom,
            Etudiant.Email
        FROM Groupe_Etudiant
        JOIN Etudiant ON Groupe_Etudiant.ID_Etudiant = Etudiant.ID
        JOIN Groupe ON Groupe_Etudiant.ID_Groupe = Groupe.ID
        WHERE Groupe.Numero = :numeroGroupe;
    ";
    $stmt = $dbConnection->prepare($query);
    $stmt->bindValue(':numeroGroupe', $numeroGroupe);
    $stmt->execute();
    $etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Affiche les étudiants dans le tableau
    if (empty($etudiants)) {
        echo "<tr><td colspan='4'>Aucun étudiant trouvé dans ce groupe.</td></tr>";
    } else {
        foreach ($etudiants as $etudiant) {
            echo "
            <tr>
                <td>" . htmlspecialchars($etudiant['NumeroDA']) . "</td>
                <td>" . htmlspecialchars($etudiant['Nom']) . "</td>
                <td>" . htmlspecialchars($etudiant['Prenom']) . "</td>
                <td>" . htmlspecialchars($etudiant['Email']) . "</td>
            </tr>
            ";
        }
    }
} catch (PDOException $e) {
    echo "<tr><td colspan='4'>Erreur lors de la récupération des étudiants : " . htmlspecialchars($e->getMessage()) . "</td></tr>";
}
?>