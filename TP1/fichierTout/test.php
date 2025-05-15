<?php
require_once '../config/db.php';
require_once '../Classes/Etudiant.php';



require_once '../config/db.php';
require_once '../Classes/Departement.php';
require_once '../Classes/Professeur.php';
require_once '../Classes/Etudiant.php';
require_once '../Classes/Cours.php';
require_once '../Classes/Groupe.php';
require_once '../Classes/GroupeProfesseur.php';
require_once '../Classes/GroupeEtudiant.php';
require_once '../Classes/CoursEnseignant.php';
require_once '../Classes/CoursEtudiant.php';
require_once '../Classes/Role.php';

try {
    echo "=== GÉNÉRATION DE DONNÉES DE TEST UNIVERSITAIRES ===\n\n";

    // ===== ROLES =====
    /*$roles = [
        new Role(null, 'Professeur'),
        new Role(null, 'Étudiant'),
        new Role(null, 'Coordonnateur')
    ];

    foreach ($roles as $role) {
        $role->create($dbConnection);
        
    }

    // ===== DÉPARTEMENTS =====
    $departements = [
        new Departement(null, 'INFO', 'Informatique', 'Département d’informatique'),
        new Departement(null, 'GEN', 'Génie', 'Département de génie'),
    ];
    foreach ($departements as $dept) {
        $dept->create($dbConnection);
        
    }

    foreach ($departements as $dept) {
        $dept->create($dbConnection);
    }*/

    // ===== PROFESSEURS =====
    $professeurs = [
        new Professeur(null, 'Durand', 'Claire', '1970-06-01', 'claire.durand@example.com','mdp1',  '2000-08-11',1, true),
        new Professeur(null, 'Martin', 'Jean', '1982-09-10', 'jean.martin@example.com', 'mdp2','2012-01-03',1,  false),
        new Professeur(null, 'Lavoie', 'Marc', '1978-04-25', 'marc.lavoie@example.com', 'mdp3','2010-02-10', 2, false),
    ];
    foreach ($professeurs as $prof) {
        $prof->create($dbConnection);
    }


    // ===== ÉTUDIANTS =====
    $etudiants = [
        new Etudiant(null, 'Benoit', 'Sarah', '2003-03-12', 'sarah.benoit@example.com', 'passetu1', null, '2024-01-15' ),
        new Etudiant(null, 'Roy', 'Alexandre', '2002-11-23', 'alexandre.roy@example.com','passetu2', null, '2024-01-15'  ),
        new Etudiant(null, 'Lambert', 'Chloé', '2001-07-05', 'chloe.lambert@example.com', 'passetu3', null, '2024-01-15' ),
    ];
    foreach ($etudiants as $etu) {
        $etu->create($dbConnection);
        
    }

    // ===== COURS =====
    $cours = [
        new Cours(null, 'INF101', 'Algorithmique', 'Cours d’introduction à l’algorithmique', 1),
        new Cours(null, 'GEN200', 'Thermodynamique', 'Thermodynamique de base', 2),
    ];
    foreach ($cours as $c) {
        $c->create($dbConnection);
        
    }

    // ===== GROUPES =====
    $groupes = [
        new Groupe(null,'G1-INF101', 'Groupe INF101', 'Groupe principal des INFO',1),
        new Groupe(null,'G2-GEN', 'Groupe GEN-B', 'Groupe principal du GEN', 2),
    ];
    foreach ($groupes as $g) {
        $g->create($dbConnection);
        
    }

   /* // ===== LIENS COURS / PROFESSEUR =====
    $CoursProf = [
        new CoursEnseignant(4, 13),
        new CoursEnseignant(5, 15),
    ];
    foreach ($CoursProf as $lcp) {
        $lcp->assign($dbConnection, $CoursProf[0].getIdCours(), $CoursProf[1].getId());
    }

    // ===== LIENS COURS / ÉTUDIANTS =====
    $liensCoursEtu = [
        new CoursEtudiant($cours[0]->Id, $etudiants[0]->Id),
        new CoursEtudiant($cours[0]->Id, $etudiants[1]->Id),
        new CoursEtudiant($cours[1]->Id, $etudiants[2]->Id),
    ];
    foreach ($liensCoursEtu as $lce) {
        $lce->assign($dbConnection);
    }

    // ===== LIENS GROUPES / PROFESSEURS =====
    $liensGroupeProf = [
        new GroupeProfesseur($groupes[0]->Id, $professeurs[1]->Id),
        new GroupeProfesseur($groupes[1]->Id, $professeurs[2]->Id),
    ];
    foreach ($liensGroupeProf as $lgp) {
        $lgp->assign($dbConnection);
    }

    // ===== LIENS GROUPES / ÉTUDIANTS =====
    $liensGroupeEtu = [
        new GroupeEtudiant($groupes[0]->Id, $etudiants[0]->Id),
        new GroupeEtudiant($groupes[0]->Id, $etudiants[1]->Id),
        new GroupeEtudiant($groupes[1]->Id, $etudiants[2]->Id),
    ];
    foreach ($liensGroupeEtu as $lge) {
        $lge->assign($dbConnection);
    }

    echo "\n=== DONNÉES INSÉRÉES ✅ ===\n";

    // ===== AFFICHAGE DE TEST =====

    echo "\n--- Étudiants inscrits au cours 'INF101' ---\n";
    foreach ($etudiants as $e) {
        $stmt = $dbConnection->prepare("SELECT * FROM CoursEtudiant WHERE Cours_Id = ? AND Etudiant_Id = ?");
        $stmt->execute([$cours[0]->Id, $e->Id]);
        if ($stmt->rowCount() > 0) {
            echo "- {$e->Prenom} {$e->Nom}\n";
        }
    }

    echo "\n--- Cours enseignés par Professeur Claire Durand ---\n";
    $stmt = $dbConnection->prepare("SELECT c.Titre FROM Cours c JOIN CoursEnseignant ce ON c.Id = ce.Cours_Id WHERE ce.Professeur_Id = ?");
    $stmt->execute([$professeurs[0]->Id]);
    $coursDurand = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($coursDurand as $c) {
        echo "- {$c['Titre']}\n";
    }

    echo "\n--- Groupes de Chloé Lambert ---\n";
    $stmt = $dbConnection->prepare("SELECT g.Nom FROM Groupe g JOIN GroupeEtudiant ge ON g.Id = ge.Groupe_Id WHERE ge.Etudiant_Id = ?");
    $stmt->execute([$etudiants[2]->Id]);
    $groupesChloe = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($groupesChloe as $g) {
        echo "- {$g['Nom']}\n";
    }

    echo "\n--- Rôles enregistrés ---\n";
    $stmt = $dbConnection->query("SELECT Nom FROM Role");
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
        echo "- {$r['Nom']}\n";
    }*/

} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}