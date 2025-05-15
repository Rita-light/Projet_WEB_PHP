<?php
require_once '../config/db.php'; // Connexion à la base de données
require_once '../Classes/Etudiant.php'; // Classe Etudiant
require_once '../FichierPHP/verifierConnexion.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.html");
    exit();
}

$id = $_SESSION['user_id']; 
$numDA = $_SESSION['numeroDA'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $dateNaissance = $_POST['dateNaissance'];
    $avatarFile = $_FILES['avatar'];

    try {
        // Utiliser la méthode de la classe Etudiant pour mettre à jour
        Etudiant::updateById($dbConnection, $id, $nom, $prenom, $email, $dateNaissance, $numDA, $avatarFile);

        // Rediriger avec un message de succès
        $_SESSION['success_message'] = "Profil mis à jour avec succès.";
        
        exit();
    } catch (PDOException $e) {
        die("Erreur lors de la mise à jour : " . $e->getMessage());
    }
    
        header("Location: ../FichierHTML/etudiantProfile.php");
}