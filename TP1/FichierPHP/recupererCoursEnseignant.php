<?php
require_once '../config/db.php'; // Inclure la connexion à la base de données
require_once '../Classes/Professeur.php'; // Inclure la classe Professeur
require_once '../FichierPHP/verifierConnexionEnseignant.php';

// Vérifiez si l'enseignant est connecté
if (!isset($_SESSION['enseignant_id'])) {
    die("Erreur : ID enseignant non défini. Veuillez vous reconnecter.");
}

$idProfesseur = $_SESSION['enseignant_id']; // ID de l'enseignant connecté

try {
    // Récupère les cours et groupes enseignés par le professeur
    $coursEtGroupes = Professeur::getGroupesParCours($dbConnection, $idProfesseur);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des cours et groupes : " . $e->getMessage());
}
?>