<?php
require_once '../FichierPHP/verifierConnexion.php'; // Vérifie la session active
require_once '../config/db.php'; 
require_once '../Classes/Professeur.php';
require_once '../Classes/Groupe.php';
require_once '../Classes/GroupeProfesseur.php';


if (!isset($_SESSION['user_id'])  || !isset($_SESSION['user_roles'])) {
    die("Erreur : ID enseignant non défini. Veuillez vous reconnecter.");
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

    // Traitement de l'ajout d'une association
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['groupe'], $_POST['enseignant'])) {
            $idGroupe = $_POST['groupe'];
            $idProfesseurAssoc = $_POST['enseignant'];

            GroupeProfesseur::assign($dbConnection, $idGroupe, $idProfesseurAssoc);
        }

        // Redirection après soumission
        header("Location: ../FichierHTML/gestion_groupe_professeur.php");
        exit();
    }

}catch (PDOException $e) {
    die("Erreur lors de la récupération des données : " . htmlspecialchars($e->getMessage()));
}



// Récupérer les groupes des cours du département de l'enseignant

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

 // Récupérer les enseignants du département
function afficherProfesseurs($db, $departementId) {
    if ($departementId) {
        $professeurs = Professeur::getProfByDepartement($db, $departementId);
    } else {
        $professeurs = Professeur::getTousLesProfesseurs($db);
    }
    
    foreach ($professeurs as $professeur) {
        echo "<option value='" . htmlspecialchars($professeur['ID']) . "'>" . htmlspecialchars($professeur['Nom'] . ' ' . $professeur['Prenom']) . "</option>";
    }
}

// Récupérer les associations Groupe-Professeur
function afficherAssociations($db, $departementId) {
    if ($departementId) {
        $associations = GroupeProfesseur::getAssociationsByDepartement($db, $departementId);
    } else {
        $associations = GroupeProfesseur::getToutesLesAssociations($db);
    }
    
    foreach ($associations as $row) {
        echo "<tr><td>" . htmlspecialchars($row['NomGroupe']) . "</td><td>" . htmlspecialchars($row['NomProfesseur']) . "</td></tr>";
    }
}


?>