<?php
require_once '../FichierPHP/verifierConnexion.php'; // Vérifie que l'enseignant est connecté
require_once '../config/db.php'; // Inclut la connexion à la base de données
require_once '../Classes/Professeur.php'; // Inclut la classe Professeur

// Vérifiez si l'enseignant est connecté
if (!isset($_SESSION['user_id'])) {
    die('Erreur : ID enseignant non défini. Veuillez vous reconnecter.');
}

$idEnseignant = $_SESSION['user_id']; // Récupère l'ID de l'enseignant depuis la session

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