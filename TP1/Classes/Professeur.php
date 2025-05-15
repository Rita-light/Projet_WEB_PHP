<?php
require_once 'Utilisateur.php';

class Professeur extends Utilisateur {
    private $dateEmbauche;
    private $idDepartement;
    private $isCoordonnateur;

    public function __construct($id, $nom, $prenom, $dateNaissance, $email, $password, $dateEmbauche, $idDepartement = null, $isCoordonnateur = false) {
        parent::__construct($id, $nom, $prenom, $dateNaissance, $email, $password);
        $this->dateEmbauche = $dateEmbauche;
        $this->idDepartement = $idDepartement;
        $this->isCoordonnateur = $isCoordonnateur;
    }

    public function getType() {
        return 'Professeur';
    }

    public function create($dbConnection) {
         // Étape 1 : insérer dans Utilisateur
        $this->id = parent::create($dbConnection);

        // Étape 2 : insérer dans Professeur
        $query = "INSERT INTO Professeur (ID, DateEmbauche, ID_Departement) VALUES (:id, :dateEmbauche, :idDepartement)";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([
            ':id' => $this->id,
            ':dateEmbauche' => $this->dateEmbauche,
            ':idDepartement' => $this->idDepartement
        ]);

         // Étape 3 : ajouter rôle Professeur
        $this->ajouterRole($dbConnection, 'Professeur');

        // Étape 4 : ajouter rôle Coordonnateur si applicable
        if ($this->isCoordonnateur) {
            $this->ajouterRole($dbConnection, 'Coordonnateur');
        }
    }

    public static function readAll($dbConnection) {
        $query = "
            SELECT 
                u.ID, u.Nom, u.Prenom, u.DateNaissance, u.Email,
                p.DateEmbauche, p.Coordonnateur, d.Nom AS Departement
            FROM Professeur p
            INNER JOIN Utilisateur u ON p.ID = u.ID
            LEFT JOIN Departement d ON p.ID_Departement = d.ID
        ";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function readByID($dbConnection, $id) {
        $query = "
            SELECT 
                u.ID, u.Nom, u.Prenom, u.DateNaissance, u.Email,
                p.DateEmbauche, p.Coordonnateur,
                d.Nom AS Departement
            FROM Professeur p
            INNER JOIN Utilisateur u ON p.ID = u.ID
            LEFT JOIN Departement d ON p.ID_Departement = d.ID
            WHERE p.ID = :id
        ";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public static function getIdDepartement($dbConnection, $idProfesseur) {
        $query = "SELECT ID_Departement FROM Professeur WHERE ID = :id";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindValue(':id', $idProfesseur, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }


    public  function updateProf($dbConnection, $id, $nom, $prenom, $dateNaissance, $email, $dateEmbauche, $idDepartement) {
        // Mise à jour dans Utilisateur
        $queryUtilisateur = "
            UPDATE Utilisateur
            SET Nom = :nom, Prenom = :prenom, DateNaissance = :dateNaissance, Email = :email
            WHERE ID = :id
        ";
        $stmt = $dbConnection->prepare($queryUtilisateur);
        $stmt->execute([
            ':id' => $id,
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':dateNaissance' => $dateNaissance,
            ':email' => $email
        ]);

        // Mise à jour dans Professeur
        $queryProf = "
            UPDATE Professeur
            SET DateEmbauche = :dateEmbauche, Coordonnateur = :coordonnateur, ID_Departement = :idDepartement
            WHERE ID = :id
        ";
        $stmt = $dbConnection->prepare($queryProf);
        $stmt->execute([
            ':id' => $id,
            ':dateEmbauche' => $dateEmbauche,
            ':coordonnateur' => $coordonnateur,
            ':idDepartement' => $idDepartement
        ]);
    }



    public static function getProfByDepartement($dbConnection, $departementId) {
        $query = "
            SELECT u.ID, u.Nom, u.Prenom
            FROM Professeur p
            INNER JOIN Utilisateur u ON p.ID = u.ID
            WHERE p.ID_Departement = :departementId
        ";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindValue(':departementId', $departementId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




    public static function getGroupesParCours($dbConnection, $idProfesseur) {
        $query = "
            SELECT 
                Cours.Nom AS NomCours,
                Cours.Description,
                Groupe.Numero AS NumeroGroupe,
                Groupe.Nom AS NomGroupe
            FROM Groupe_Professeur
            JOIN Groupe ON Groupe_Professeur.ID_Groupe = Groupe.ID
            JOIN Cours ON Groupe.ID_Cours = Cours.ID
            WHERE Groupe_Professeur.ID_Professeur = :idProfesseur
            ORDER BY Cours.Nom, Groupe.Numero;
        ";

        $stmt = $dbConnection->prepare($query);
        $stmt->bindValue(':idProfesseur', $idProfesseur);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourne les données sous forme de tableau associatif
    }
}
?>