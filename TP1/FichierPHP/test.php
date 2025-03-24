<?php
require_once '../config/db.php';
require_once '../Classes/Etudiant.php';


// Inclure la configuration et les classes
require_once '../Classes/Departement.php';
require_once '../Classes/Etudiant.php';
require_once '../Classes/Professeur.php';
require_once '../Classes/Cours.php';
require_once '../Classes/Groupe.php';
require_once '../Classes/GroupeProfesseur.php';
require_once '../Classes/GroupeEtudiant.php';
require_once '../Classes/CoursEnseignant.php';
require_once '../Classes/CoursEtudiant.php';


try {
    // Test : Ajouter un département
    echo "Création d'un département...\n";
    $departement = new Departement(null, 'Lecture', 'Informatique', 'Département des technologies de l\'information');
    $departement->create($dbConnection);
    echo "Département créé avec succès.\n";

    // Test : Lire tous les départements
    echo "Lecture de tous les départements...\n";
    $departements = Departement::readAll($dbConnection);
    foreach ($departements as $dept) {
        echo "ID: " . $dept['ID'] . ", Code: " . $dept['Code'] . ", Nom: " . $dept['Nom'] . "\n";
    }

    // Test : Ajouter un étudiant
    echo "Création d'un étudiant...\n";
    $etudiant = new Etudiant(null, 'Mogui', 'Jean', '2000-01-01', 'jean.mogui@example.com', '2025H001', '2025-01-01', 'securepassword');
    $etudiant->create($dbConnection);
    echo "Étudiant ajouté avec succès.\n";

    // Test : Lire tous les étudiants
    echo "Lecture de tous les étudiants...\n";
    $etudiants = Etudiant::readAll($dbConnection);
    foreach ($etudiants as $etu) {
        echo "ID: " . $etu['ID'] . ", Nom: " . $etu['Nom'] . ", Prénom: " . $etu['Prenom'] . ", Email: " . $etu['Email'] . "\n";
    }

    // Test : Ajouter un professeur
    echo "Création d'un professeur...\n";
    $professeur = new Professeur(null, 'Martin', 'Claire', '1980-05-15', 'claire.martin@example.com', '2020-09-01', 'securepassword', true);
    $professeur->create($dbConnection);
    echo "Professeur ajouté avec succès.\n";

    // Test : Lire tous les professeurs
    echo "Lecture de tous les professeurs...\n";
    $professeurs = Professeur::readAll($dbConnection);
    foreach ($professeurs as $prof) {
        echo "ID: " . $prof['ID'] . ", Nom: " . $prof['Nom'] . ", Prénom: " . $prof['Prenom'] . ", Email: " . $prof['Email'] . "\n";
    }

    // Test : Ajouter un cours
    echo "Création d'un cours...\n";
    $cours = new Cours(null, 'INFO101', 'Introduction à l\'informatique', 'Cours de base pour les étudiants en informatique', 1);
    $cours->create($dbConnection);
    echo "Cours ajouté avec succès.\n";

    // Test : Lire tous les cours
    echo "Lecture de tous les cours...\n";
    $coursList = Cours::readAll($dbConnection);
    foreach ($coursList as $course) {
        echo "ID: " . $course['ID'] . ", Nom: " . $course['Nom'] . ", Département: " . $course['ID_Departement'] . "\n";
    }

    // Test : Assigner un étudiant à un cours
    echo "Assignation d'un étudiant à un cours...\n";
    $coursEtudiant = new CoursEtudiant(1, 60); // ID_Cours = 1, ID_Etudiant = 60
    $coursEtudiant->assign($dbConnection);
    echo "Étudiant assigné au cours avec succès.\n";

    // Test : Lire les étudiants d'un cours
    echo "Lecture des étudiants inscrits à un cours...\n";
    $etudiantsCours = CoursEtudiant::readByCours($dbConnection, 1); // ID_Cours = 1
    foreach ($etudiantsCours as $etuCours) {
        echo "Nom: " . $etuCours['Nom'] . ", Prénom: " . $etuCours['Prenom'] . "\n";
    }

    // Test : Assigner un professeur à un groupe
    echo "Assignation d'un professeur à un groupe...\n";
    $groupeProfesseur = new GroupeProfesseur(1, 1); // ID_Groupe = 1, ID_Professeur = 1
    $groupeProfesseur->assign($dbConnection);
    echo "Professeur assigné au groupe avec succès.\n";

    // Test : Lire les groupes assignés à un professeur
    echo "Lecture des groupes assignés à un professeur...\n";
    $groupesProf = GroupeProfesseur::readByProfesseur($dbConnection, 1); // ID_Professeur = 1
    foreach ($groupesProf as $groupe) {
        echo "Nom du groupe: " . $groupe['Nom'] . "\n";
    }

} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
?>