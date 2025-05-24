<?
require_once '../config/db.php'; 
require_once '../Classes/Professeur.php';
require_once '../Classes/Cours.php';
require_once '../Classes/CoursEnseignant.php';



// Vérifiez si l'enseignant est connecté
if (!isset($_SESSION['user_id'])  || !isset($_SESSION['user_roles'])) {
    die("Erreur : ID enseignant non défini. Veuillez vous reconnecter.");
}

$idUtilisateur = $_SESSION['user_id']; 
$role = $_SESSION['user_roles'][0];

$departementId = null; 
$coursOptions = [];
$enseignantsOptions = [];
$associations = [];


try {
    
    if ($role === 'Administrateur'){
        //Accès globlal
        $coursOptions = Cours::readAll($dbConnection);
        $enseignantsOptions = Professeur::readAll($dbConnection);
        $associations = CoursEnseignant::getToutesLesAssociations($dbConnection);

    }
    else {

        // Récupérer l'ID du département de l'enseignant connecté
        $departementId = Professeur::getidDepartement($dbConnection, $idUtilisateur);

        if (!$departementId) {
            die("Erreur : département non trouvé pour cet enseignant.");
        }

        // Récupérer les cours et prof du même département
        
        $coursOptions = Cours::getCoursByID($dbConnection, $departementId);
        $enseignantsOptions = Professeur::getProfByDepartement($dbConnection, $departementId);

        // Récupérer les associations cours-enseignants existantes
        $associations = CoursEnseignant::getAssoc($dbConnection, $departementId);

    }

    // Traitement de l'ajout d'une association
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cours'], $_POST['enseignant'])) {
            $idCours = $_POST['cours'];
            $idEnseignantAssoc = $_POST['enseignant'];

            CoursEnseignant::assign($dbConnection, $idCours, $idEnseignantAssoc);

            // Redirection pour éviter un nouvel envoi du formulaire
            header("Location: gestion_cours_enseignant.php");
            exit();
        }


}catch (PDOException $e) {
    die("Erreur lors de la récupération des données : " . htmlspecialchars($e->getMessage()));
}