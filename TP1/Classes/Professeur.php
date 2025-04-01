<?php
require_once 'Individu.php';

class Professeur extends Individu {
    private $dateEmbauche;
    private $password;
    private $coordonnateur;

    public function __construct($id, $nom, $prenom, $dateNaissance, $email, $dateEmbauche, $password, $coordonnateur = false) {
        parent::__construct($id, $nom, $prenom, $dateNaissance, $email);
        $this->dateEmbauche = $dateEmbauche;
        $this->password = $password;
        $this->coordonnateur = $coordonnateur;
    }

    public function getType() {
        return 'Professeur';
    }

    public function create($dbConnection) {
        $query = "INSERT INTO Professeur (Nom, Prenom, DateNaissance, Email, DateEmbauche, Password, Coordonnateur) 
                  VALUES (:nom, :prenom, :dateNaissance, :email, :dateEmbauche, :password, :coordonnateur)";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([
            ':nom' => $this->nom,
            ':prenom' => $this->prenom,
            ':dateNaissance' => $this->dateNaissance,
            ':email' => $this->email,
            ':dateEmbauche' => $this->dateEmbauche,
            ':password' => $this->password,
            ':coordonnateur' => $this->coordonnateur,
        ]);
    }

    public static function readAll($dbConnection) {
        $query = "SELECT * FROM Professeur";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function readByID($dbConnection, $id) {
        $query = "
            SELECT 
                Professeur.ID, Professeur.Nom, Professeur.Prenom, Professeur.DateNaissance, 
                Professeur.Email, Professeur.DateEmbauche, Professeur.Coordonnateur, 
                Departement.Nom AS Departement
            FROM Professeur
            LEFT JOIN Departement ON Professeur.ID_Departement = Departement.ID
            WHERE Professeur.ID = :id
        ";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne les données sous forme de tableau associatif
    }

    public static function getIdDepartement($dbConnection, $idEnseignant){
        $queryDept = "
            SELECT ID_Departement 
            FROM Professeur
                WHERE ID = :idEnseignant;
        ";
        $stmtDept = $dbConnection->prepare($queryDept);
        $stmtDept->bindValue(':idEnseignant', $idEnseignant);
        $stmtDept->execute();
        $departementId = $stmtDept->fetchColumn();

        return $departementId;
    }

    public static function update($dbConnection, $id, $nom, $prenom, $dateNaissance, $email) {
        $query = "
            UPDATE Professeur
            SET 
                Nom = :nom,
                Prenom = :prenom,
                DateNaissance = :dateNaissance,
                Email = :email
            WHERE ID = :id
        ";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([
            ':id' => $id,
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':dateNaissance' => $dateNaissance,
            ':email' => $email
        ]);
    }


    public static function getProfByDepartement($dbConnection, $departementId) {
        $queryEnseignants = "
            SELECT ID, Nom, Prenom 
            FROM Professeur 
            WHERE ID_Departement = :departementId
        ";
        $stmtEnseignants = $dbConnection->prepare($queryEnseignants);
        $stmtEnseignants->bindValue(':departementId', $departementId);
        $stmtEnseignants->execute();
        $enseignantsOptions = $stmtEnseignants->fetchAll(PDO::FETCH_ASSOC);

        return $enseignantsOptions;
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