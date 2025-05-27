<?php
require_once '../config/db.php'; 
require_once '../Classes/Professeur.php';
require_once '../FichierPHP/verifierConnexion.php';

// Vérifiez si l'enseignant est connecté
if (!isset($_SESSION['user_id'])) {
    die("Erreur : ID enseignant non défini. Veuillez vous reconnecter.");
}

$idProfesseur = $_SESSION['user_id']; // ID de l'enseignant connecté

try {
    // Récupère les cours et groupes enseignés par le professeur
    $coursEtGroupes = Professeur::getGroupesParCours($dbConnection, $idProfesseur);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des cours et groupes : " . $e->getMessage());
}
?>