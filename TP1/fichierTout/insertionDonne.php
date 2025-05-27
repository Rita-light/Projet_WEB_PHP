<?php
require_once(__DIR__ . '/../config/db.php');
require_once(__DIR__ . '/../Classes/Departement.php');
require_once(__DIR__ . '/../Classes/Professeur.php');
require_once(__DIR__ . '/../Classes/Etudiant.php');
require_once(__DIR__ . '/../Classes/Cours.php');
require_once(__DIR__ . '/../Classes/Groupe.php');
require_once(__DIR__ . '/../Classes/GroupeProfesseur.php');
require_once(__DIR__ . '/../Classes/GroupeEtudiant.php');
require_once(__DIR__ . '/../Classes/CoursEnseignant.php');
require_once(__DIR__ . '/../Classes/CoursEtudiant.php');
require_once(__DIR__ . '/../Classes/Role.php');
require_once(__DIR__ . '/../Classes/Utilisateur.php');
require_once(__DIR__ . '/../Classes/UtilisateurRole.php');
require_once(__DIR__ . '/../lib/Security.php');




try {
    
    //--------------------- insertion de trois départements -----------------
    $departements = [
        ['INF', 'Informatique', 'Département d’informatique'],
        ['BIO', 'Biologie', 'Département de biologie'],
        ['MAT', 'Mathématiques', 'Département de mathématiques']
    ];

    foreach ($departements as [$code, $nom, $desc]) {
        $dep = new Departement(null, $code, $nom, $desc);
        $dep->create($dbConnection);
    }


    // --------------- insertion des rôles ----------------------------
    $roles = ['Administrateur', 'Étudiant', 'Professeur', 'Coordonnateur'];

    foreach ($roles as $nom) {
        $stmt = $dbConnection->prepare("INSERT INTO Role (Nom) VALUES (:nom)");
        $stmt->execute([':nom' => $nom]);
    }

    //----------------- insertion des cours --------------------------
    // Récupérer tous les départements pour connaître leur ID
    $stmt = $dbConnection->query("SELECT ID, Code FROM Departement");
    $departements = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($departements as $dep) {
        $depId = $dep['ID'];
        $code = $dep['Code'];

        $cours = [];

        // Définir les cours selon le code du département
        if ($code === 'INF') {
            $cours = [
                ['INF101', 'Programmation 1', 'Introduction à la programmation en C'],
                ['INF102', 'Structures de données', 'Étude des structures comme les listes, piles, files'],
                ['INF201', 'Programmation orientée objet', 'Programmation en Java avec POO']
            ];
        } elseif ($code === 'BIO') {
            $cours = [
                ['BIO101', 'Biologie cellulaire', 'Étude des cellules animales et végétales'],
                ['BIO202', 'Génétique', 'Bases de la transmission génétique'],
                ['CH100', 'Chimie', 'Composition des substances quiforment l\'univers']
            ];
        } elseif ($code === 'MAT') {
            $cours = [
                ['MAT101', 'Algèbre linéaire', 'Matrices, vecteurs et espaces vectoriels'],
                ['MAT201', 'Calcul différentiel', 'Fonctions, limites, dérivées'],
                ['GC14', 'Géometrie ', 'Etude des veteurs et plans']
            ];
        }

        // Insertion des cours
        foreach ($cours as [$codeCours, $titre, $description]) {
            $coursObj = new Cours(null, $codeCours, $titre, $description, $depId);
            $coursObj->create($dbConnection);
        }
    }

    //--------------------insertion des groupes -------------------------
    // Récupérer tous les cours existants
    $stmt = $dbConnection->query("SELECT ID, Numero FROM Cours");
    $cours = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($cours as $coursData) {
        $idCours = $coursData['ID'];
        $codeCours = $coursData['Numero'];

        // Générer un nombre aléatoire de groupes (1 ou 2)
        $nbGroupes = rand(1, 2);

        for ($i = 1; $i <= $nbGroupes; $i++) {
            $numero = "G{$i}-{$codeCours}";
            $nom = "Groupe {$i} du cours {$codeCours}";
            $description = "Ce groupe correspond au groupe {$i} pour le cours {$codeCours}";

            $groupe = new Groupe(null, $numero, $nom, $description, $idCours);
            $groupe->create($dbConnection);
        }
    }

    // -------------------------------- Insertion des professeurs ------------------
    // Récupérer tous les départements
    $stmt = $dbConnection->query("SELECT ID, Code FROM Departement");
    $departements = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prénom/Noms fictifs pour variation
    $prenoms = [
        'Alice', 'Bob', 'Claire', 'David', 'Emma', 'Francois', 'Gabriel', 'Helene',
        'Julien', 'Lucas', 'Marie', 'Nicolas', 'Olivia', 'Paul', 'Quentin', 'Raphael',
        'Samuel', 'Thomas', 'Victor', 'William', 'Yasmine', 'Zoe', 'Antoine', 'Camille',
        'Leo', 'Sarah', 'Maxime', 'Hugo', 'Lea', 'Nathan', 'Laura', 'Manon'
    ];


    $noms = [
        'Martin', 'Durand', 'Lefebvre', 'Moreau', 'Roy', 'Gagnon', 'Bouchard', 'Pelletier',
        'Lemoine', 'Marchand', 'Blanchard', 'Baron', 'Robert', 'Richard', 'Poirier', 'Girard',
        'Denis', 'Morin', 'Fortin', 'Dupuis', 'Noel', 'Guerin', 'Perrot', 'Masson',
        'Julien', 'Brunet', 'Bernard', 'Lemoine', 'Fabre', 'Renard'
    ];


    foreach ($departements as $dep) {
        $idDepartement = $dep['ID'];

        // Créer entre 3 et 4 professeurs pour ce département
        $nbProfs = rand(4, 7);

        // Sélectionner un coordonnateur au hasard
        $indexCoordo = rand(0, $nbProfs - 1);

        for ($i = 0; $i < $nbProfs; $i++) {
            $prenom = $prenoms[array_rand($prenoms)];
            $nom = $noms[array_rand($noms)];
            $dateNaissance = date('Y-m-d', strtotime('-' . rand(30, 50) . ' years'));
            $email = strtolower($prenom . '.' . $nom . rand(100, 999) . '@example.com');
            $password = 'prof1234'; 
            $dateEmbauche = date('Y-m-d', strtotime('-' . rand(1, 15) . ' years'));
            $isCoordonnateur = ($i === $indexCoordo);

            $prof = new Professeur(null, $nom, $prenom, $dateNaissance, $email, $password, $dateEmbauche, $idDepartement, $isCoordonnateur);
            $prof->create($dbConnection);
        }
    }

    //---------------------- insertion de l'étudiant -----------------------------
    // Prénoms et noms fictifs
    
    for ($i = 0; $i < 40; $i++) {
        $prenom = $prenoms[array_rand($prenoms)];
        $nom = $noms[array_rand($noms)];
        $dateNaissance = date('Y-m-d', strtotime('-' . rand(18, 25) . ' years'));
        $email = strtolower($prenom . '.' . $nom . rand(100, 999) . '@etu.univ.com');
        $password = 'etu1234';  

        $numeroDA = null;

        // Date d’inscription aléatoire
        $dateInscription = date('Y-m-d', strtotime('-' . rand(0, 730) . ' days'));

        // Avatar nul
        $avatar = null;

        // Création de l'objet et insertion
        $etudiant = new Etudiant(null, $nom, $prenom, $dateNaissance, $email, $password, $numeroDA, $dateInscription, $avatar);
        $etudiant->create($dbConnection);
    }

    //---------------- simple utilisateur avec role, admin et coordo ---------

    // ---------- Administrateurs ----------
    $admins = [
        ['Martin', 'Laforest', '1980-03-15', 'martin.laforest@univ.com'],
        ['Sophie', 'Brunet', '1985-06-22', 'sophie.brunet@univ.com'],
    ];

    foreach ($admins as [$prenom, $nom, $naissance, $email]) {
        $admin = new Utilisateur(null, $nom, $prenom, $naissance, $email, 'admin1234');
        $admin->create($dbConnection);
        // Vérification de l'ID
        try {
            $admin->ajouterRole($dbConnection, 'Administrateur');
        } catch (Exception $e) {
        
            echo "Erreur lors de l'ajout du rôle à " . $admin->getNomComplet() . " : " . $e->getMessage() . "\n";
        }
    }

    

    //----------------------- insertion relation cours / étudiant -----

    // 1. Récupère tous les IDs de cours
    $coursStmt = $dbConnection->query("SELECT ID FROM Cours");
    $coursIds = $coursStmt->fetchAll(PDO::FETCH_COLUMN);

    // 2. Récupère tous les IDs d'étudiants
    $etudiantStmt = $dbConnection->query("SELECT ID FROM Etudiant");
    $etudiantIds = $etudiantStmt->fetchAll(PDO::FETCH_COLUMN);

    // 3. Assigner entre 10 et 15 étudiants par cours
    foreach ($coursIds as $idCours) {
        // Mélanger les étudiants
        shuffle($etudiantIds);

        // Nombre aléatoire d'étudiants à inscrire : entre 10 et 15
        $nbInscrits = rand(10, 15);

        // Prendre les X premiers
        $etudiantsAInscrire = array_slice($etudiantIds, 0, $nbInscrits);

        foreach ($etudiantsAInscrire as $idEtudiant) {
            // Créer et assigner l'inscription
            $inscription = new CoursEtudiant($idCours, $idEtudiant);
            $inscription->assign($dbConnection);
        }
    }

    //------------------------ relation cours / professeur -------------------
    // Étape 1 : Récupérer tous les cours avec leur département
    $sqlCours = "SELECT ID, ID_Departement FROM Cours";
    $coursResult = $dbConnection->query($sqlCours);
    $coursList = $coursResult->fetchAll(PDO::FETCH_ASSOC);

    // Étape 2 : Récupérer tous les professeurs avec leur département
    $sqlProfs = "SELECT ID, ID_Departement FROM Professeur";
    $profsResult = $dbConnection->query($sqlProfs);
    $professeurs = $profsResult->fetchAll(PDO::FETCH_ASSOC);

    // Étape 3 : Pour chaque cours, trouver un prof du même département
    foreach ($coursList as $cours) {
        $idCours = $cours['ID'];
        $idDeptCours = $cours['ID_Departement'];

        // Filtrer les professeurs du même département
        $profsCompatibles = array_filter($professeurs, function($prof) use ($idDeptCours) {
            return $prof['ID_Departement'] === $idDeptCours;
        });

        if (empty($profsCompatibles)) {
            echo " Aucun professeur trouvé pour le cours $idCours (département $idDeptCours)\n";
            continue;
        }

        // Choisir un prof au hasard dans la liste compatible
        $profChoisi = array_rand($profsCompatibles);
        $idProf = $profsCompatibles[$profChoisi]['ID'];

        // Étape 4 : Assigner le professeur au cours
        CoursEnseignant::assign($dbConnection, $idCours, $idProf);
        echo " Professeur $idProf assigné au cours $idCours (département $idDeptCours)\n";
    }


} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}