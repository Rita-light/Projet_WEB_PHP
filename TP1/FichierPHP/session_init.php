<?php
session_name("MaSessionSecurisee");


// Empêche PHP d’utiliser les identifiants de session dans l’URL
ini_set('session.use_trans_sid', 0);

// Mode strict
ini_set('session.use_strict_mode', 1);

// Limite le cookie au site actuel
ini_set('session.cookie_samesite', 'Strict');

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => false, 
    'httponly' => true,
    'samesite' => 'Strict'
]);

// Démarrer la session
session_start();

if (!isset($_SESSION['initiée'])) {
    session_regenerate_id(true);
    $_SESSION['initiée'] = true;
}
