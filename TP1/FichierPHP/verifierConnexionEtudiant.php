<?php
session_start(); // Démarrer la session

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_email']) || $_SESSION['user_role'] !== 'etudiant') {
    header("Location: connexion.html"); // Rediriger vers la page de connexion
    exit();
}
?>