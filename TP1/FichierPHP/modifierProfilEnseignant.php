<?php
    require_once '../FichierPHP/verifierConnexionEnseignant.php'; 
    require_once '../config/db.php'; 
    require_once '../Classes/Professeur.php'; 


if (!isset($_SESSION['enseignant_id'])) {
    die('Erreur : ID enseignant non défini. Veuillez vous reconnecter.');
}

$idEnseignant = $_SESSION['enseignant_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $dateNaissance = $_POST['dateNaissance'];

    try {

        // Met à jour les informations de l'enseignant
        Professeur::update($dbConnection, $idEnseignant, $nom, $prenom, $dateNaissance, $email);

        $_SESSION['success_message'] = "Profil mis à jour avec succès.";
        header("Location: ../FichierHTML/enseignantProfile.php");
        exit();
    } catch (PDOException $e) {
        die("Erreur lors de la mise à jour : " . $e->getMessage());
    }
} else {
    header("Location: ../FichierHTML/enseignantProfile.php");
    exit();
}
?>