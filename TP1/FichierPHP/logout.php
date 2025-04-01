<?php
session_start();
session_destroy(); // Supprimer toutes les données de session
header("Location: ../FichierHTML/connexion.html"); // Rediriger vers la page de connexion
exit();
?>