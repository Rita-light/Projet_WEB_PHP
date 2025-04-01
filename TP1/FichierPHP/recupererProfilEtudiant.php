<?php
require_once '../config/db.php'; // Connexion à la base de données
require_once '../Classes/Etudiant.php'; // Classe Etudiant



if (!isset($_SESSION['numeroDA'])) {
    header("Location: connexion.html");
    exit();
}

$numeroDA = $_SESSION['numeroDA']; // Utiliser le numéro DA pour identifier l'étudiant

try {
    // Récupérer les informations de l'étudiant via la méthode de la classe
    $etudiant = Etudiant::readByNumeroDA($dbConnection, $numeroDA);

    if (!$etudiant) {
        die("Erreur : Étudiant introuvable.");
    }

    // Retourner l'objet étudiant
    return $etudiant;
} catch (PDOException $e) {
    die("Erreur lors de la récupération des informations : " . $e->getMessage());
}