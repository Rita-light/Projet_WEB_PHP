<?php
require_once '../config/db.php';
require_once '../lib/Security.php';
session_start();

$security = new Security();




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];

    /*try {
        // Vérifier si l'utilisateur est un étudiant
        $sqlEtudiant = "SELECT * FROM Etudiant WHERE Email = :email AND Password = :password";
        $stmtEtudiant = $dbConnection->prepare($sqlEtudiant);
        $stmtEtudiant->bindValue(':email', $email);
        $stmtEtudiant->bindValue(':password', $password); // Hachage recommandé pour les mots de passe
        $stmtEtudiant->execute();

        if ($stmtEtudiant->rowCount() === 1) {
            // Si l'utilisateur est un étudiant
            $etudiant = $stmtEtudiant->fetch(PDO::FETCH_ASSOC);
            $_SESSION['user_role'] = 'etudiant';
            $_SESSION['user_email'] = $email;
            $_SESSION['numeroDA'] = $etudiant['NumeroDA'];
            $_SESSION['user_name'] = $etudiant['Nom'] . ' ' . $etudiant['Prenom'];
            header("Location: ../FichierHTML/etudiant.php");
            exit();
        }

        // Vérifier si l'utilisateur est un professeur
        $sqlProfesseur = "SELECT * FROM Professeur WHERE Email = :email AND Password = :password";
        $stmtProfesseur = $dbConnection->prepare($sqlProfesseur);
        $stmtProfesseur->bindValue(':email', $email);
        $stmtProfesseur->bindValue(':password', $password); 
        
        $stmtProfesseur->execute();

        if ($stmtProfesseur->rowCount() === 1) {
            // Si l'utilisateur est un enseignant
            $professeur = $stmtProfesseur->fetch();
            $_SESSION['user_role'] = 'enseignant';
            $_SESSION['user_email'] = $email;
            $_SESSION['enseignant_id'] = $professeur['ID'];
            $_SESSION['is_coordonnateur'] = (bool) $professeur['Coordonnateur']; 
            $_SESSION['user_name'] = $professeur['Nom'] . ' ' . $professeur['Prenom'];


            header("Location: ../FichierHTML/enseignant.php");
            exit();
        }

        // Si aucun résultat n'a été trouvé
        $_SESSION['error_message'] = "Email ou mot de passe incorrect.";
        header("Location: ../FichierHTML/connexion.html");
        exit();
    } catch (PDOException $e) {
        // Gérer les erreurs
        echo "Erreur lors de la vérification des identifiants : " . $e->getMessage();
    }*/


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

                // Étape 5 : Rediriger selon le rôle (exemple)
                if (in_array('Étudiant', $roles)) {
                    header("Location: ../FichierHTML/etudiant.php");
                } elseif (in_array('Professeur', $roles)) {
                    header("Location: ../FichierHTML/enseignant.php");
                } elseif (in_array('Coordonateur', $roles)) {
                    $_SESSION['is_coordonnateur'] == true;
                }
                else {
                    header("Location: ../FichierHTML/accueil.php");
                }
                
                exit();
            } else {
                $_SESSION['error_message'] = "Mot de passe incorrect.";
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