<?php
require_once '../FichierPHP/verifierConnexion.php'; 
require_once '../config/db.php'; 
require_once '../Classes/Etudiant.php'; 



// Vérification de l'étudiant connecté
if (!isset($_SESSION['user_id'])) {
    die('Erreur : étudiant non connecté.');
}

$idEtudiant = $_SESSION['user_id']; 

try {
    
    // Récupérer les cours et les groupes associés
    $coursEtudiant = Etudiant::getCoursEtGroupe($dbConnection, $idEtudiant);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des cours : " . $e->getMessage());
}
?>