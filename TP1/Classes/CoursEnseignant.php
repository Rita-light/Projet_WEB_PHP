<?php
class CoursEnseignant {
    private $idCours;
    private $idProfesseur;

    public function __construct($idCours, $idProfesseur) {
        $this->idCours = $idCours;
        $this->idProfesseur = $idProfesseur;
    }

    public static function assign($dbConnection, $idCours, $idEnseignantAssoc) {
        $query = "INSERT INTO Cours_Enseignant (ID_Cours, ID_Professeur) VALUES (:idCours, :idProfesseur)";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindValue(':idCours', $idCours);
        $stmt->bindValue(':idEnseignant', $idEnseignantAssoc);
        $stmt->execute();
    }

    public static function readByCours($dbConnection, $idCours) {
        $query = "SELECT * FROM Professeur 
                  INNER JOIN Cours_Enseignant ON Professeur.ID = Cours_Enseignant.ID_Professeur
                  WHERE Cours_Enseignant.ID_Cours = :idCours";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([':idCours' => $idCours]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAssoc($dbConnection, $departementId){
        $queryAssociations = "
            SELECT Cours.Nom AS NomCours, 
                CONCAT(Professeur.Nom, ' ', Professeur.Prenom) AS NomEnseignant, 
                Cours_Enseignant.ID AS AssociationID
            FROM Cours_Enseignant
            JOIN Cours ON Cours.ID = Cours_Enseignant.ID_Cours
            JOIN Professeur ON Professeur.ID = Cours_Enseignant.ID_Professeur
            WHERE Cours.ID_Departement = :departementId
        ";
        $stmtAssociations = $dbConnection->prepare($queryAssociations);
        $stmtAssociations->bindValue(':departementId', $departementId);
        $stmtAssociations->execute();
        $associations = $stmtAssociations->fetchAll(PDO::FETCH_ASSOC);
        
        return $associations;
    }
}
?>