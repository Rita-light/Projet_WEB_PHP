<?php
require_once(__DIR__ . '/../config/db.php');
require_once(__DIR__ . '/../Classes/Utilisateur.php');
require_once(__DIR__ . '/../Classes/UtilisateurRole.php');

// Catégories selon les rôles
$categories = [
    'Etudiant' => [],
    'Professeur' => [],
    'ProfesseurCoordo' => [],
    'ProfesseurAdmin' => [],
    'Coordo' => [],
    'Admin' => [],
    'ProfesseurCoordoAdmin' => []
];

try {
    $stmt = $dbConnection->query("
        SELECT U.ID, U.Email, R.Nom AS Role
        FROM Utilisateur U
        JOIN Utilisateur_Role UR ON U.ID = UR.ID_Utilisateur
        JOIN Role R ON UR.ID_Role = R.ID
    ");
    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Regrouper les rôles par utilisateur
    $utilisateurs = [];
    foreach ($resultats as $ligne) {
        $id = $ligne['ID'];
        $email = $ligne['Email'];
        $role = $ligne['Role'];

        if (!isset($utilisateurs[$id])) {
            $utilisateurs[$id] = ['email' => $email, 'roles' => []];
        }
        $utilisateurs[$id]['roles'][] = $role;
    }

    // Classer les utilisateurs dans les bonnes catégories
    foreach ($utilisateurs as $id => $data) {
        $email = $data['email'];
        $roles = $data['roles'];
        sort($roles);

        $motDePasse = 'inconnu';
        $roleSet = array_unique($roles); // Éviter les doublons accidentels

        // Utilitaires booléens
        $isEtudiant = in_array('Étudiant', $roleSet);
        $isProf = in_array('Professeur', $roleSet);
        $isCoordo = in_array('Coordonnateur', $roleSet);
        $isAdmin = in_array('Administrateur', $roleSet);

        // Attribution aux catégories (par priorité)
        if ($isProf && $isCoordo && $isAdmin) {
            $categories['ProfesseurCoordoAdmin'][] = [$id, $email, 'prof1234'];
        } elseif ($isProf && $isAdmin && !$isCoordo) {
            $categories['ProfesseurAdmin'][] = [$id, $email, 'prof1234'];
        } elseif ($isProf && $isCoordo && !$isAdmin) {
            $categories['ProfesseurCoordo'][] = [$id, $email, 'prof1234'];
        } elseif ($isAdmin && !$isProf && !$isCoordo) {
            $categories['Admin'][] = [$id, $email, 'admin1234'];
        } elseif ($isCoordo && !$isProf && !$isAdmin) {
            $categories['Coordo'][] = [$id, $email, 'coordo1234'];
        } elseif ($isProf && !$isAdmin && !$isCoordo) {
            $categories['Professeur'][] = [$id, $email, 'prof1234'];
        } elseif ($isEtudiant && !$isProf && !$isCoordo && !$isAdmin) {
            $categories['Etudiant'][] = [$id, $email, 'etu1234'];
        } elseif ($isEtudiant) {
            // Cas d'un étudiant avec d'autres rôles
            $categories['Etudiant'][] = [$id, $email, 'etu1234'];
        }
    }

    // Écriture dans un fichier texte
    $cheminFichier = __DIR__ . '/../fichierTout/utilisateurs_roles.txt';
    if (!is_dir(dirname($cheminFichier))) {
        mkdir(dirname($cheminFichier), 0777, true);
    }

    $fichier = fopen($cheminFichier, 'w');

    if (!$fichier) {
        throw new Exception("Impossible d’ouvrir le fichier.");
    }

    foreach ($categories as $nomCategorie => $listeUtilisateurs) {
        fwrite($fichier, "==== $nomCategorie ====\n");
        $compteur = 0;
        foreach ($listeUtilisateurs as [$id, $email, $motDePasse]) {
            fwrite($fichier, "ID: $id | Email: $email | Mot de passe: $motDePasse\n");
            if (++$compteur >= 5) break;
        }
        fwrite($fichier, "\n");
    }

    fclose($fichier);
    echo "Fichier généré avec succès : $cheminFichier\n";

} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
