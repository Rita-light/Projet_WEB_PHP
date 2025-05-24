<?php
require_once '../config/db.php';
require_once '../Classes/Groupe.php';
require_once '../Classes/Professeur.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['idGroupe'])) {
    $idGroupe = $_GET['idGroupe'];

    try {
        $idCours = Groupe::getIdCoursParGroupe($dbConnection, $idGroupe);
        if ($idCours) {
            $professeurs = Professeur::getByCours($dbConnection, $idCours);
            echo json_encode($professeurs);
        } else {
            echo json_encode([]);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>
