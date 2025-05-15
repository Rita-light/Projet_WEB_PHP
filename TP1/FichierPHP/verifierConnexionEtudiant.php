<?php
session_start(); // Démarrer la session

// Vérifier si l'utilisateur est connecté
/*if (!isset($_SESSION['user_email']) || $_SESSION['user_roles'] !== 'Étudiant') {
    header("Location: connexion.html"); // Rediriger vers la page de connexion
    exit();
}*/

    if (!isset($_SESSION['user_email']) || !in_array('Étudiant',  $_SESSION['user_roles'])) {
        header("Location: connexion.html"); // Rediriger vers la page de connexion
        exit();
    }
?>