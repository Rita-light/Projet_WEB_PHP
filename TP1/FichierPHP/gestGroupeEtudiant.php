<?php
require_once '../FichierPHP/verifierConnexionEnseignant.php';
require_once '../config/db.php';
require_once '../Classes/Professeur.php';
require_once '../Classes/Etudiant.php';
require_once '../Classes/Groupe.php';
require_once '../Classes/GroupeEtudiant.php';


if (!isset($_SESSION['enseignant_id'])) {
    die("Erreur : ID enseignant non défini.");
}

$idEnseignant = $_SESSION['enseignant_id'];
$departementId = null;

try {
    // Récupérer l'ID du département de l'enseignant
    $departementId = Professeur::getidDepartement($dbConnection, $idEnseignant);

    if (!$departementId) {
        die("Erreur : Département non trouvé.");
    }

    // Traitement de l'ajout
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['groupe'], $_POST['etudiant'])) {
        $idGroupe = $_POST['groupe'];
        $idEtudiant = $_POST['etudiant'];

        // Vérifier si l'étudiant est inscrit au cours du groupe
        $queryCheckCours = "
            SELECT Cours_Etudiant.ID_Cours
            FROM Cours_Etudiant
            JOIN Groupe ON Groupe.ID_Cours = Cours_Etudiant.ID_Cours
            WHERE Groupe.ID = :idGroupe AND Cours_Etudiant.ID_Etudiant = :idEtudiant
        ";
        $stmtCheckCours = $dbConnection->prepare($queryCheckCours);
        $stmtCheckCours->bindValue(':idGroupe', $idGroupe);
        $stmtCheckCours->bindValue(':idEtudiant', $idEtudiant);
        $stmtCheckCours->execute();
        $isInscrit = $stmtCheckCours->fetch();

        if (!$isInscrit) {
            die("Erreur : L'étudiant n'est pas inscrit au cours de ce groupe.");
        }

        // Vérifier si l'étudiant est déjà dans un autre groupe pour ce cours
        $queryCheckGroupe = "
            SELECT Groupe_Etudiant.ID
            FROM Groupe_Etudiant
            JOIN Groupe ON Groupe_Etudiant.ID_Groupe = Groupe.ID
            WHERE Groupe.ID_Cours = (
                SELECT ID_Cours FROM Groupe WHERE ID = :idGroupe
            ) AND Groupe_Etudiant.ID_Etudiant = :idEtudiant
        ";
        $stmtCheckGroupe = $dbConnection->prepare($queryCheckGroupe);
        $stmtCheckGroupe->bindValue(':idGroupe', $idGroupe);
        $stmtCheckGroupe->bindValue(':idEtudiant', $idEtudiant);
        $stmtCheckGroupe->execute();
        $alreadyInGroupe = $stmtCheckGroupe->fetch();

        if ($alreadyInGroupe) {
            die("Erreur : L'étudiant appartient déjà à un autre groupe pour ce cours.");
        }

        // Ajouter l'association
        $queryAdd = "
            INSERT INTO Groupe_Etudiant (ID_Groupe, ID_Etudiant)
            VALUES (:idGroupe, :idEtudiant)
        ";
        $stmtAdd = $dbConnection->prepare($queryAdd);
        $stmtAdd->bindValue(':idGroupe', $idGroupe);
        $stmtAdd->bindValue(':idEtudiant', $idEtudiant);
        $stmtAdd->execute();

        header("Location: ../FichierHTML/gestion_groupe_etudiant.php");
        exit();
    }

} catch (PDOException $e) {
    die("Erreur lors de la récupération des données : " . htmlspecialchars($e->getMessage()));
}


// ----------------------
// Fonctions d'affichage
// ----------------------

function afficherGroupes($db, $departementId) {
    $groupes = Groupe::getGroupsByDepartement($db, $departementId); // Call the Groupe method
    foreach ($groupes as $groupe) {
        echo "<option value='" . htmlspecialchars($groupe['ID']) . "'>" . htmlspecialchars($groupe['NomGroupe']) . "</option>";
    }
}

function afficherEtudiants($db) {
    $etudiants = Etudiant::readAll($db); // Fetch data from the Etudiant class
    foreach ($etudiants as $etudiant) {
        echo "<option value='" . htmlspecialchars($etudiant['ID']) . "'>" . htmlspecialchars($etudiant['Nom'] . ' ' . $etudiant['Prenom']) . "</option>";
    }
}

function afficherAssociations($db, $departementId) {
    $associations = GroupeEtudiant::getAssociationsByDepartement($db, $departementId);
    foreach ($associations as $row) {
        echo "<tr><td>" . htmlspecialchars($row['GroupeNom']) . "</td><td>" . htmlspecialchars($row['Nom'] . ' ' . $row['Prenom']) . "</td></tr>";
    }
}


?>