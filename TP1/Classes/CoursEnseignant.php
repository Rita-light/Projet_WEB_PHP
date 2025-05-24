<?php
require_once(__DIR__ . '/../config/db.php');

class CoursEnseignant {
    private $idCours;
    private $idProfesseur;

    public function __construct($idCours, $idProfesseur) {
        $this->idCours = $idCours;
        $this->idProfesseur = $idProfesseur;
    }

    public function getIdCours() {
        return $this->idCours;
    }

    public function getId() {
        return $this->IdProfesseur;
    }

    /**
     * Assigne un enseignant à un cours.
     *
     * Cette méthode insère une nouvelle relation entre un cours et un enseignant dans la table `Cours_Enseignant`.
     *
     * @param PDO $dbConnection Connexion à la base de données.
     * @param int $idCours Identifiant du cours.
     * @param int $idEnseignantAssoc Identifiant de l'enseignant.
     * @return void
     **/
    public static function assign($dbConnection, $idCours, $idEnseignantAssoc) {
        $query = "INSERT INTO Cours_Enseignant (ID_Cours, ID_Professeur) VALUES (:idCours, :idProfesseur)";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindValue(':idCours', $idCours); // Reste correct
        $stmt->bindValue(':idProfesseur', $idEnseignantAssoc); // Correction ici
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

    

   public static function getAssoc($dbConnection, $departementId) {
        $queryAssociations = "
            SELECT Cours.Nom AS NomCours, 
                CONCAT(Utilisateur.Nom, ' ', Utilisateur.Prenom) AS NomEnseignant, 
                Cours_Enseignant.ID AS AssociationID
            FROM Cours_Enseignant
            JOIN Cours ON Cours.ID = Cours_Enseignant.ID_Cours
            JOIN Professeur ON Professeur.ID = Cours_Enseignant.ID_Professeur
            JOIN Utilisateur ON Utilisateur.ID = Professeur.ID 
            WHERE Cours.ID_Departement = :departementId
        ";
        
        $stmtAssociations = $dbConnection->prepare($queryAssociations);
        $stmtAssociations->bindValue(':departementId', $departementId, PDO::PARAM_INT);
        $stmtAssociations->execute();
        
        return $stmtAssociations->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function delete($dbConnection, $associationID) {
        $query = "DELETE FROM Cours_Enseignant WHERE ID = :associationID";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindValue(':associationID', $associationID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() ;
    }

    public static function getToutesLesAssociations($dbConnection) {
        $query = "
            SELECT 
                Cours.Nom AS NomCours, 
                CONCAT(Utilisateur.Nom, ' ', Utilisateur.Prenom) AS NomEnseignant, 
                Cours_Enseignant.ID AS AssociationID
            FROM Cours_Enseignant
            JOIN Cours ON Cours.ID = Cours_Enseignant.ID_Cours
            JOIN Professeur ON Professeur.ID = Cours_Enseignant.ID_Professeur
            JOIN Utilisateur ON Utilisateur.ID = Professeur.ID
        ";

        $stmt = $dbConnection->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Dans CoursEnseignant.php
public static function getProfesseursParCours($db, $idCours) {
    $stmt = $db->prepare("
        SELECT Professeur.ID, Utilisateur.Nom, Utilisateur.Prenom
        FROM Professeur
        JOIN Utilisateur ON Utilisateur.ID = Professeur.ID
        JOIN CoursEnseignant ON CoursEnseignant.ID_Professeur = Professeur.ID
        WHERE CoursEnseignant.ID_Cours = :idCours
    ");
    $stmt->bindValue(':idCours', $idCours, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}
?>