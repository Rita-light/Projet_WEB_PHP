<?php
require_once '../Classes/Etudiant.php';
require_once '../config/db.php'; // Connexion à la base


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $operation = $_POST['operation']; 
    if ($operation === 'Inscrire') {
        inscrireEtudiant($dbConnection);
    }
    elseif ($operation === 'modifier') {
        if (isset($_POST['numeroDA'])) {
            $numeroDA = htmlspecialchars($_POST['numeroDA']);
        } else {
            die("Erreur : Numéro DA non défini.");
        }
    
        modifierEtudiant($dbConnection, $numeroDA);
    }
    
}

// Vérifier si une action de suppression est demandée
if (isset($_GET['action']) && $_GET['action'] === 'supprimer' && isset($_GET['numeroDA'])) {
    $numeroDA = htmlspecialchars($_GET['numeroDA']); // Sécuriser les données

    // Appeler la fonction pour supprimer l'étudiant
    if (Etudiant::deleteByNumeroDA($dbConnection, $numeroDA)) {
        // Message de confirmation
        echo "<script>
                alert('L\\'étudiant a été supprimé avec succès.');
                window.location.href = '../FichierHTML/gestAfficheEtudiant.php';
              </script>";
              
        exit;
    } else {
        // Message d'erreur
        echo "<script>
                alert('L\\'étudiant n'a pas été supprimé');
                window.location.href = '../FichierHTML/gestAfficheEtudiant.php';
              </script>";
        header("Location: connexion.html");
    }
}


function inscrireEtudiant($dbConnection) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupération des données
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $dateNaissance = $_POST['dateNaissance'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $dateInscription = date('Y-m-d');
        //$avatarFile = $_FILES['avatar'];

        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $avatarFile = $_FILES['avatar'];
            // Traitez l'avatar ici
        } else {
            $avatarFile = null; // Pas de fichier envoyé ou erreur lors du téléchargement
        }

        try {
            // Création de l'étudiant
            $etudiant = new Etudiant(null, $nom, $prenom, $dateNaissance, $email, null, $dateInscription, $password, null);
            $numeroDA = $etudiant->create($dbConnection, $avatarFile);

            echo "<p style='color:green;'>Étudiant inscrit avec succès. Numéro DA : <strong>$numeroDA</strong></p>";
            echo"<script>
                window.location.href = '../FichierHTML/gestAfficheEtudiant.php';
              </script>";
        } catch (Exception $e) {
            echo "<p style='color:red;'>Erreur : " . $e->getMessage() . "</p>";
        }
    }
}

function afficherEtudiants($dbConnection) {
    $etudiants = Etudiant::readAll($dbConnection); // Récupérer tous les étudiants

    foreach ($etudiants as $etudiant) {
        $numeroDA = htmlspecialchars($etudiant['NumeroDA']);
        $nom = htmlspecialchars($etudiant['Nom']);
        $prenom = htmlspecialchars($etudiant['Prenom']);
        $dateNaissance = htmlspecialchars($etudiant['DateNaissance']);
        $email = htmlspecialchars($etudiant['Email']);
        $dateInscription = htmlspecialchars($etudiant['DateInscription']);

        // Chemin de l'avatar (image)
        $avatarPath = !empty($etudiant['Avatar']) ? htmlspecialchars($etudiant['Avatar']) : null;
                if (empty($avatarPath)) {
            // Si aucun avatar n'est défini, on affiche l'image par défaut
           $avatarPath = "../avatars/default_img.png";
        }

        echo "<tr>
                <td><img src='$avatarPath' width='50' height='50' alt='Avatar'></td>
                <td>$numeroDA</td>
                <td>$nom</td>
                <td>$prenom</td>
                <td>$dateNaissance</td>
                <td>$email</td>
                <td>$dateInscription</td>
                <td class='button-container'>
                    <a href='../FichierHTML/gestModifierEtudiant.php?numeroDA=$numeroDA' class='button'>Modifier</a>
                    <a href='../FichierPHP/gestionEtudiant.php?action=supprimer&numeroDA=$numeroDA' class='button' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet étudiant ?\")'>Supprimer</a>
                </td>
              </tr>";
    }
    
}


function modifierEtudiant($dbConnection, $numeroDA){
    
    // Vérifier si une requête POST est reçue
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        

        // Récupérer les données du formulaire
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $email = htmlspecialchars($_POST['email']);
        $dateNaissance = htmlspecialchars($_POST['dateNaissance']);

        
        try {
            $result = Etudiant::update($dbConnection,$numeroDA, $email, $nom, $prenom, $dateNaissance);

            if ($result) {
                echo "<script>
                        alert('Les informations de l\\'étudiant ont été mises à jour avec succès.');
                        window.location.href = '../FichierHTML/gestAfficheEtudiant.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Erreur : Impossible de modifier les informations.');
                        window.history.back();
                      </script>";
                      
            }
        } catch (Exception $e) {
            echo "<p style='color:red;'>Erreur : " . $e->getMessage() . "</p>";
        }
        

    }
}
?>
