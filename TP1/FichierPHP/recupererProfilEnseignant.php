<?php
require_once '../FichierPHP/verifierConnexion.php'; 
require_once '../config/db.php'; 
require_once '../Classes/Professeur.php';

// Vérifiez si l'enseignant est connecté
if (!isset($_SESSION['user_id'])) {
    die('Erreur : ID enseignant non défini. Veuillez vous reconnecter.');
}

$idEnseignant = $_SESSION['user_id']; 

try {
    // Récupère les informations de l'enseignant
    $enseignant = Professeur::readByID($dbConnection, $idEnseignant);

    if (!$enseignant) {
        die("Erreur : Impossible de récupérer les informations de l'enseignant.");
    }
} catch (PDOException $e) {
    die("Erreur lors de la récupération du profil : " . $e->getMessage());
}
?>