<?php
session_start();
if (!isset($_SESSION['user_email']) || empty($_SESSION['user_roles'])) {
    header("Location: connexion.html");
    exit();
}
