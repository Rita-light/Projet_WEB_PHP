<?php
require_once '../config/db.php';
session_start();

// Inclure le fichier de configuration pour la base de données


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
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
    }
}
?>