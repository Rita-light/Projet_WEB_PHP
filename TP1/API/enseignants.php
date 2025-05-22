<?php
header('Content-Type: application/json');
require_once '../config/db.php';
require_once '../lib/fonction_professeur.php';

$method = $_SERVER['REQUEST_METHOD'];
$requestUri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
$id = isset($requestUri[2]) ? intval($requestUri[2]) : null;

switch ($method) {
    case 'GET':
        if ($id) {
            getEnseignant($dbConnection, $id);
        } else {
            getAllEnseignants($dbConnection);
        }
        break;

    case 'POST':
        addEnseignant($dbConnection);
        break;

    case 'PUT':
        if ($id) {
            updateEnseignant($dbConnection, $id);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'ID requis']);
        }
        break;

    case 'DELETE':
        if ($id) {
            deleteEnseignant($dbConnection, $id);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'ID requis']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Méthode non autorisée']);
        break;
}
