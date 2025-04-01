<?php
require_once '../config/db.php'; // Connexion à la base de données
require_once '../Classes/Etudiant.php'; // Classe Etudiant
require_once '../FichierPHP/verifierConnexionEtudiant.php';

if (!isset($_SESSION['numeroDA'])) {
    header("Location: connexion.html");
    exit();
}

$numeroDA = $_SESSION['numeroDA']; // Utiliser le numéro DA pour identifier l'étudiant

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $dateNaissance = $_POST['dateNaissance'];

    try {
        // Utiliser la méthode de la classe Etudiant pour mettre à jour
        Etudiant::updateByNumeroDA($dbConnection, $numeroDA, $nom, $prenom, $dateNaissance);

        // Rediriger avec un message de succès
        $_SESSION['success_message'] = "Profil mis à jour avec succès.";
        header("Location: ../FichierHTML/etudiantProlife.php");
        exit();
    } catch (PDOException $e) {
        die("Erreur lors de la mise à jour : " . $e->getMessage());
    }
}