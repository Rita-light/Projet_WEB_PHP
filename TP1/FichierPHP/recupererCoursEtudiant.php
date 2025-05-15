<?php
require_once '../FichierPHP/verifierConnexion.php'; // Vérification session active
require_once '../config/db.php'; // Connexion à la base de données
require_once '../Classes/Etudiant.php'; // Inclusion de la classe Etudiant



// Vérification de l'étudiant connecté
if (!isset($_SESSION['user_id'])) {
    die('Erreur : étudiant non connecté.');
}

$idEtudiant = $_SESSION['user_id']; // Récupérer le numéro DA de l'étudiant connecté

try {
    
    // Récupérer les cours et les groupes associés
    $coursEtudiant = Etudiant::getCoursEtGroupe($dbConnection, $idEtudiant);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des cours : " . $e->getMessage());
}
?>