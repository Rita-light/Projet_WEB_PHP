<?php
require_once '../FichierPHP/verifierConnexion.php';
require_once '../config/db.php';
require_once '../Classes/Professeur.php';
require_once '../Classes/Etudiant.php';
require_once '../Classes/Groupe.php';
require_once '../Classes/GroupeEtudiant.php';


if (!isset($_SESSION['user_id'])) {
    die("Erreur : ID enseignant non défini.");
}

$idUtilisateur = $_SESSION['user_id']; 
$role = $_SESSION['user_roles'][0];
$departementId = null; 

if ($role !== 'Administrateur') {
        $departementId = Professeur::getidDepartement($dbConnection, $idUtilisateur);
        if (!$departementId) {
            die("Erreur : département non trouvé pour cet enseignant.");
        }
}

try {
    // Traitement de l'ajout
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['groupe'], $_POST['etudiant'])) {
        $idGroupe = $_POST['groupe'];
        $idEtudiant = $_POST['etudiant'];

        GroupeEtudiant::assign($dbConnection, $idEtudiant, $idGroupe);
        
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
    if ($departementId) {
        $groupes = Groupe::getGroupsByDepartement($db, $departementId);
    } else {
        $groupes = Groupe::getTousLesGroupes($db);
    }

    foreach ($groupes as $groupe) {
        echo "<option value='" . htmlspecialchars($groupe['ID']) . "'>" . htmlspecialchars($groupe['Nom']) . "</option>";
    }
}

function afficherEtudiants($db) {
    $etudiants = Etudiant::readAll($db); 
    $etudiants = Etudiant::readAll($db);
    foreach ($etudiants as $etudiant) {
        echo "<option value='" . htmlspecialchars($etudiant['ID']) . "'>" . htmlspecialchars($etudiant['Nom'] . ' ' . $etudiant['Prenom']) . "</option>";
    }
}

function afficherAssociations($db, $departementId) {
    if ($departementId === null) {
        $associations = GroupeEtudiant::getAllAssociations($db);
    } else {
        $associations = GroupeEtudiant::getAssociationsByDepartement($db, $departementId);
    }

    foreach ($associations as $row) {
        echo "<tr><td>" . htmlspecialchars($row['GroupeNom']) . "</td><td>" . htmlspecialchars($row['Nom'] . ' ' . $row['Prenom']) . "</td></tr>";
    }
}


?>