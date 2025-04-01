<?php
require_once '../FichierPHP/verifierConnexionEtudiant.php'; // Vérification session active
require_once '../config/db.php'; // Connexion à la base de données
require_once '../Classes/Etudiant.php'; // Inclusion de la classe Etudiant



// Vérification de l'étudiant connecté
if (!isset($_SESSION['numeroDA'])) {
    die('Erreur : étudiant non connecté.');
}

$numeroDA = $_SESSION['numeroDA']; // Récupérer le numéro DA de l'étudiant connecté

try {
    // Obtenir l'ID de l'étudiant depuis la table Étudiant
    $query = "SELECT ID FROM Etudiant WHERE NumeroDA = :numeroDA";
    $stmt = $dbConnection->prepare($query);
    $stmt->bindValue(':numeroDA', $numeroDA);
    $stmt->execute();
    $idEtudiant = $stmt->fetchColumn(); // Récupère l'ID de l'étudiant

    // Récupérer les cours et les groupes associés
    $coursEtudiant = Etudiant::getCoursEtGroupe($dbConnection, $idEtudiant);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des cours : " . $e->getMessage());
}
?>