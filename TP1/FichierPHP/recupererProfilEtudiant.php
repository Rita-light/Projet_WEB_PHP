<?php
require_once '../config/db.php'; 
require_once '../Classes/Etudiant.php'; 



if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.html");
    exit();
}

$id = $_SESSION['user_id']; 

try {
    // Récupérer les informations de l'étudiant via la méthode de la classe
    $etudiant = Etudiant::readById($dbConnection, $id);

    if (!$etudiant) {
        die("Erreur : Étudiant introuvable.");
    }

    // Retourner l'objet étudiant
    return $etudiant;
} catch (PDOException $e) {
    die("Erreur lors de la récupération des informations : " . $e->getMessage());
}