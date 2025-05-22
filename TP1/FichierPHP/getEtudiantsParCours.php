<?php
require_once '../config/db.php';
require_once '../Classes/Etudiant.php';
require_once '../Classes/Groupe.php';
require_once '../Classes/CoursEtudiant.php';

if (!isset($_GET['idGroupe'])) {
    http_response_code(400);
    echo json_encode(["error" => "ID de groupe manquant"]);
    exit();
}

$idGroupe = (int) $_GET['idGroupe'];

try {
    // 1. Récupérer le cours lié à ce groupe
    $idCours = Groupe::getIdCoursParGroupe($dbConnection, $idGroupe);

    if (!$idCours) {
        http_response_code(404);
        echo json_encode([]);
        exit();
    }

    // 2. Récupérer les étudiants inscrits à ce cours
    $etudiants = CoursEtudiant::readByCours($dbConnection, $idCours);

    // 3. Retourner la liste au format JSON
    header('Content-Type: application/json');
    echo json_encode($etudiants);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
