<?php
$host = 'tp1-db-1';
$dbname = 'Universite3';
$user = 'root';
$pass = 'root';

try {
    //  Connexion sans base pour la création
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     // Suppression de la base existante
    $pdo->exec("DROP DATABASE IF EXISTS `$dbname`;");
    echo " Base de données '$dbname' supprimée si elle existait.\n";

    //  Création de la base de données si elle n'existe pas
    $pdo->exec("CREATE DATABASE `$dbname` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    echo " Base de données '$dbname' créée \n";

    //  Se reconnecter à la base créée
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fonction pour exécuter un fichier SQL contenant plusieurs requêtes
    function executeSqlFile($pdo, $filePath) {
        if (!file_exists($filePath)) {
            echo " Erreur : Le fichier '$filePath' est introuvable.\n";
            return;
        }

        // Lire tout le contenu du fichier
        $sql = file_get_contents($filePath);
        
        // Séparer les requêtes SQL sur les points-virgules (attention aux déclencheurs et procédures stockées)
        $queries = array_filter(array_map('trim', explode(";", $sql)));

        // Exécuter chaque requête individuellement
        foreach ($queries as $query) {
            if (!empty($query)) {
                try {
                    $pdo->exec($query);
                } catch (PDOException $e) {
                    echo " Erreur lors de l'exécution d'une requête : " . $e->getMessage() . "\n";
                }
            }
        }
        echo "Exécution réussie de '$filePath'.\n";
    }

    //  Exécuter creation des tables
    executeSqlFile($pdo, 'fichierTout/creation.sql');

    //  Exécuter insertion
    // Insertion des données via un fichier PHP
    if (file_exists('fichierTout/insertionDonne.php')) {
        require 'fichierTout/insertionDonne.php';
        echo "insertionDonne.php exécuté.\n";
    } else {
        echo "Fichier 'insertionDonne.php' introuvable.\n";
    }

    // recuper donne test
    if (file_exists('FichierPHP/recupererDonneTest.php')) {
        require 'FichierPHP/recupererDonneTest.php';
        echo "recupererDonneTest.php exécuté., donné recupéré\n";
    } else {
        echo "Fichier recupererDonneTest.php introuvable.\n";
    }

    // Exécuter declencheur
    $query = " 
        CREATE TRIGGER Verifier_Association_Before_Insert
        BEFORE INSERT ON Groupe_Professeur
        FOR EACH ROW
        BEGIN
            -- Vérification de l'association professeur-groupe :
            IF NOT EXISTS (
                SELECT 1 
                FROM Cours_Enseignant CE 
                JOIN Groupe G ON CE.ID_Cours = G.ID_Cours
                WHERE CE.ID_Professeur = NEW.ID_Professeur
                AND G.ID = NEW.ID_Groupe
            ) THEN
                SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'L\'association professeur-groupe est invalide : le professeur n\'enseigne pas le cours de ce groupe.';
            END IF;
        END;

    ";
    try {
        $result = $pdo->exec($query);
    
        // Vérification de succès
        if ($result !== false) {
            echo "Déclencheur créé avec succès.\n";
        } else {
            echo "Aucune modification effectuée, mais pas d'erreur signalée.\n";
        }
    } catch (PDOException $e) {
        // Gestion des erreurs
        echo " Erreur lors de la création du déclencheur : " . $e->getMessage() . "\n";
    }
    

} catch (PDOException $e) {
    echo " Erreur PDO : " . $e->getMessage() . "\n";
}
?>
