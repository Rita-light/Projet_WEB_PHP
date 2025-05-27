# Projet_WEB_PHP
Gestion des cours dans un collège

# Fonctionnalités de l'application
##
## Etudiant
* Afficher et modifier ses informations
* Consulter ses cours
* Authentification

## Enseignant
+ Afficher et modifier ses informations
+ Consulter la liste des cours qu'il donne et des groupe dans lesquels il est affecté
+ Afficher la liste de ses étudiants  par groupe
* Authentification

## Coordonnateur
En plus des fonctionnalités des enseignant, le coordonnateur peut : 
+ Gérer les cours

    Pour les cours de son departement, il peut ajouter et afficher les associations: 
    + Cours et enseignant
    + Groupe et enseignant
    + Groupe et étudiant
    * Supprimer  les associations cours et enseignant

## Administrateur
L'administrateur lui peut : 
+  Gérer les étudiants
    * Afficher les étudiants
    * Inscrire les étudiants
    * modifier les informations d'un étudiant
+ Gérer les cours
    Pour les cours de tout departement, il peut ajouter et afficher les associations: 
    + Cours et enseignant
    + Groupe et enseignant
    + Groupe et étudiant
    * Supprimer  les associations cours et enseignant

# Information de test

* Les informations de connexion des utilisateur sont dans le fichier : ../fihierTout/utilisateur_roles.txt


## Fichier Important
* fichier pour initiation de la bd : initDB.php
* fichier pour ouverture de l'applivation : index.php
    - Ils sont à la racine du projet

* fichier de test unitaire : /fichierTout/testUnitaire.php

* les commande pour tester mon api professeur sont dans le fichier 

Ils sont à la racine du projet : /fichierTout/test.txt