<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_email']) || $_SESSION['user_role'] !== 'enseignant') {
    header("Location: connexion.html");
    exit();
}
?>