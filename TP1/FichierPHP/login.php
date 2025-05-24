<?php
require_once(__DIR__ . '/../FichierPHP/session_init.php');
require_once(__DIR__ . '/../config/db.php');
require_once(__DIR__ . '/../lib/Security.php');
require_once(__DIR__ . '/../lib/Validation.php');
require_once(__DIR__ . '/../lib/Journalisation.php');


/*--------------------------------------------------------------------------
------------------------------Validation des données de connexion--------------------------------
----------------------------------------------------------------------------*/

$validation = new Validation();
$security = new Security();

// ------------ Générer le jeton csrf de session -----------------------

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = $security->generateToken();
}

//Nettoyage et validation de l'email

$ip = $_SERVER['REMOTE_ADDR'];
$email = isset($_POST['email']) ? $_POST['email'] : ''; 
$email= $validation-> sanitizeInput($email); 
$validation->required($email, 'email'); 
$validation->maxLength($email, 'email', 75); 
$validation->validEmail($email, 'email');

// Valider le mot de passe  
$password = isset($_POST['password']) ? $_POST['password'] : ''; 
$validation->required($password, 'password'); 
$validation->minLength($password, 'password', 4);

if ($validation->fails()) {
    $erreurs = $validation->getErrors();
    $message = implode("\n", $erreurs);

    echo "<script>
        alert(" . json_encode($message) . ");
        window.location.href = '../FichierHTML/connexion.html'; 
    </script>";
    exit;
}


//Vérifier le nombre de tentative de connexion

if ($validation->estBloque($dbConnection, $email, $ip)) {

    enregistrerEvenementConnexion('erreur_securite', $dbConnection, $utilisateur['ID'] ?? null, 'Tentative d\'accès à une page non autorisée, adresse ip bloqué');

     echo "<script>
        alert('Trop de tentatives de connexion. Veuillez réessayer dans 15 minutes.');
        window.location.href = '../FichierHTML/connexion.html';
     </script>";
     exit();
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        
        // Étape 1 : Chercher l'utilisateur par email
        $sql = "SELECT * FROM Utilisateur WHERE Email = :email";
        $stmt = $dbConnection->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
            

            // Étape 2 : Vérifier le mot de passe avec Security::verifierMotDePasse()
            if ($security->verifyPassword($password, $utilisateur['Password'])) {
                
                // Étape 3 : Récupérer les rôles de l'utilisateur
                $sqlRoles = "SELECT r.Nom FROM Role r
                             INNER JOIN Utilisateur_Role ur ON r.ID = ur.ID_Role
                             WHERE ur.ID_Utilisateur = :idUtilisateur";
                $stmtRoles = $dbConnection->prepare($sqlRoles);
                $stmtRoles->bindValue(':idUtilisateur', $utilisateur['ID']);
                $stmtRoles->execute();
                $roles = $stmtRoles->fetchAll(PDO::FETCH_COLUMN); // retourne un tableau avec tous les noms de rôle

                // Étape 4 : Enregistrer les infos dans la session
                $_SESSION['user_id'] = $utilisateur['ID'];
                $_SESSION['user_email'] = $utilisateur['Email'];
                $_SESSION['user_name'] = $utilisateur['Nom'] . ' ' . $utilisateur['Prenom'];
                $_SESSION['user_roles'] = $roles;

                //Initialiser les pages accessibles
                $pagesParRole = require_once '../lib/Role.php';

                $pagesUtilisateur = [];
                foreach ($_SESSION['user_roles'] as $role) {
                    if (isset($pagesParRole[$role])) {
                        $pagesUtilisateur = array_merge($pagesUtilisateur, $pagesParRole[$role]);
                    }
                }
                $pagesUtilisateur = array_unique($pagesUtilisateur, SORT_REGULAR);
                $_SESSION['pages_utilisateur'] = $pagesUtilisateur;

                // si c'est un etudiant
                // Étape 3 : si l'utilisateur est un étudiant, récupérer son NumeroDA
                if (in_array('Étudiant', $_SESSION['user_roles'])) {
                    $stmtEtudiant = $dbConnection->prepare("SELECT NumeroDA FROM Etudiant WHERE ID = :id");
                    $stmtEtudiant->bindValue(':id', $utilisateur['ID']);
                    $stmtEtudiant->execute();
                    $etudiant = $stmtEtudiant->fetch(PDO::FETCH_ASSOC);

                    if ($etudiant) {
                        $_SESSION['numeroDA'] = $etudiant['NumeroDA'];
                    }
                }

                //supprimer les tentative echoué et enregitrement de la connexion
                $validation->reinitialiserTentatives($dbConnection, $email, $ip);

                enregistrerEvenementConnexion('connexion', $dbConnection, $utilisateur['ID'], 'Connexion réussie');

                // Étape 5 : Rediriger selon le rôle (exemple)
                header("Location: ../FichierHTML/acceuil.php");
        
                exit();
            } else {
                $_SESSION['error_message'] = "Mot de passe incorrect.";

                // Enregistrer la tentative échouée
                $validation->enregistrerTentative($dbConnection, $email, $ip) ;

                enregistrerEvenementConnexion('Echec', $dbConnection, null, 'Échec de connexion pour email : ' . $email);
                $_SESSION['error_message'] = "Mot de passe incorrect.";
                header("Location: ../FichierHTML/connexion.html");
                exit();

            }
        } else {
            $_SESSION['error_message'] = "Aucun utilisateur trouvé avec cet email.";
        }

        header("Location: ../FichierHTML/connexion.html");
        exit();
    } 
    catch (PDOException $e) {
        echo "Erreur lors de la connexion : " . $e->getMessage();
    }
}
?>