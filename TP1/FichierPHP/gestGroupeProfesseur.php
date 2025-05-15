<?php
require_once '../FichierPHP/verifierConnexion.php'; // Vérifie la session active
require_once '../config/db.php'; 
require_once '../Classes/Professeur.php';
require_once '../Classes/Groupe.php';
require_once '../Classes/GroupeProfesseur.php';

// Vérifiez si l'enseignant est connecté
if (!isset($_SESSION['user_id'])) {
    die("Erreur : ID enseignant non défini. Veuillez vous reconnecter.");
}

$idEnseignant = $_SESSION['user_id']; // ID de l'enseignant connecté
$departementId = null; // ID du département

try {

    // Récupérer le département de l'enseignant connecté
    $departementId = Professeur::getidDepartement($dbConnection, $idEnseignant);

    if (!$departementId) {
        die("Erreur : Département non trouvé pour cet enseignant.");
    }

    // Traitement des ajouts (Groupe-Professeur)
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
} catch (PDOException $e) {
    die("Erreur lors de la récupération des données : " . htmlspecialchars($e->getMessage()));
}


// Récupérer les groupes des cours du département de l'enseignant

function afficherGroupes($db, $departementId) {
    $groupes = Groupe::getGroupsByDepartement($db, $departementId); // Call the Groupe method
    foreach ($groupes as $groupe) {
        echo "<option value='" . htmlspecialchars($groupe['ID']) . "'>" . htmlspecialchars($groupe['NomGroupe']) . "</option>";
    }
}

 // Récupérer les enseignants du département
function afficherProfesseurs($db, $departementId) {
    $professeurs = Professeur::getProfByDepartement($db, $departementId); // Fetch data from the Professeur class
    foreach ($professeurs as $professeur) {
        echo "<option value='" . htmlspecialchars($professeur['ID']) . "'>" . htmlspecialchars($professeur['Nom'] . ' ' . $professeur['Prenom']) . "</option>";
    }
}

// Récupérer les associations Groupe-Professeur
function afficherAssociations($db, $departementId) {
    $associations = GroupeProfesseur::getAssociationsByDepartement($db, $departementId); // Fetch data
    foreach ($associations as $row) {
        echo "<tr><td>" . htmlspecialchars($row['NomGroupe']) . "</td><td>" . htmlspecialchars($row['NomProfesseur']) . "</td></tr>";
    }
}

?>