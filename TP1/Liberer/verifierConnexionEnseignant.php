<?php
session_start();

// Vérifier si l'utilisateur est connecté

    if (!isset($_SESSION['user_email']) || !in_array('Professeur',  $_SESSION['user_roles'])) {
        header("Location: connexion.html"); // Rediriger vers la page de connexion
        exit();
    }
?>