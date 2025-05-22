<?php
session_start();

require_once '../config/db.php';
require_once '../lib/Journalisation.php';

$idUtilisateur = $_SESSION['user_id'] ?? null;
enregistrerEvenementConnexion('deconnexion', $dbConnection, $idUtilisateur, 'Déconnexion manuelle');

session_unset();
session_destroy(); // Supprimer toutes les données de session


// Supprimer le cookie de session si existant
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}


header("Location: ../FichierHTML/connexion.html"); // Rediriger vers la page de connexion
exit();
?>