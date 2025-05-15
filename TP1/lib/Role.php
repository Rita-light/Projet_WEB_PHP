<?php

$pagesParRole = [
    'Étudiant' => [
        ['label' => 'Mes cours', 'url' => 'etudiantCours.php'],
        ['label' => 'Mon profil', 'url' => 'etudiantProfile.php'],
    ],
    'Professeur' => [
        ['label' => 'Profil Enseignant', 'url' => 'enseignatProfile.php'],
        ['label' => 'Cours Enseignant', 'url' => 'enseignantCours.php'],
        ['label' => 'Liste Étudiants', 'url' => 'listeEtudiant.php'],
    ],
    'Coordonnateur' => [
        ['label' => 'Gestion des cours', 'url' => 'gestionCours.php'],
        ['label' => 'Gestion des étudiants', 'url' => 'gestEtudiant.php'],
    ],
    'Administrateur' => [
        ['label' => 'Gestion des cours', 'url' => 'gestionCours.php'],
        ['label' => 'Gestion des étudiants', 'url' => 'gestEtudiant.php'],
    ]
];

return $pagesParRole;
