<?php
require_once '../FichierPHP/session_init.php';
if (!isset($_SESSION['user_email']) || empty($_SESSION['user_roles'])) {
    header("Location: connexion.html");
    exit();
}
