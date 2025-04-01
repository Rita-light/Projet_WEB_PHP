<?
require_once '../config/db.php'; // Connexion à la base de données
require_once '../Classes/Professeur.php';
require_once '../Classes/Cours.php';
require_once '../Classes/CoursEnseignant.php';



// Vérifiez si l'enseignant est connecté
if (!isset($_SESSION['enseignant_id'])) {
    die("Erreur : ID enseignant non défini. Veuillez vous reconnecter.");
}

$idEnseignant = $_SESSION['enseignant_id']; // ID de l'enseignant connecté
$departementId = null; // ID du département de l'enseignant
$coursOptions = [];
$enseignantsOptions = [];
$associations = [];

try {

    // Récupérer l'ID du département de l'enseignant connecté

    $departementId = Professeur::getidDepartement($dbConnection, $idEnseignant);

    if (!$departementId) {
        die("Erreur : département non trouvé pour cet enseignant.");
    }

    // Récupérer les cours du même département
    
    $coursOptions = Cours::getCoursByID($dbConnection, $departementId);

    // Récupérer les enseignants du même département
    
    $enseignantsOptions = Professeur::getProfByDepartement($dbConnection, $departementId);

    // Récupérer les associations cours-enseignants existantes
    
    $associations = CoursEnseignant::getAssoc($dbConnection, $departementId);

    // Traitement de l'ajout d'une association
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cours'], $_POST['enseignant'])) {
        $idCours = $_POST['cours'];
        $idEnseignantAssoc = $_POST['enseignant'];

        $queryAddAssoc = "
            INSERT INTO Cours_Enseignant (ID_Cours, ID_Professeur)
            VALUES (:idCours, :idEnseignant)
        ";
        $stmtAddAssoc = $dbConnection->prepare($queryAddAssoc);
        $stmtAddAssoc->bindValue(':idCours', $idCours);
        $stmtAddAssoc->bindValue(':idEnseignant', $idEnseignantAssoc);
        $stmtAddAssoc->execute();
        //CoursEnseignant::assign($dbConnection, $idCours, $idEnseignantAssoc);

        // Redirection pour éviter un nouvel envoi du formulaire
        header("Location: gestion_cours_enseignant.php");
        exit();
    }
} catch (PDOException $e) {
    die("Erreur lors de la récupération des données : " . htmlspecialchars($e->getMessage()));
}