<?php
class CoursEnseignant {
    private $idCours;
    private $idProfesseur;

    public function __construct($idCours, $idProfesseur) {
        $this->idCours = $idCours;
        $this->idProfesseur = $idProfesseur;
    }

    public function assign($dbConnection) {
        $query = "INSERT INTO Cours_Enseignant (ID_Cours, ID_Professeur) VALUES (:idCours, :idProfesseur)";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([
            ':idCours' => $this->idCours,
            ':idProfesseur' => $this->idProfesseur,
        ]);
    }

    public static function readByCours($dbConnection, $idCours) {
        $query = "SELECT * FROM Professeur 
                  INNER JOIN Cours_Enseignant ON Professeur.ID = Cours_Enseignant.ID_Professeur
                  WHERE Cours_Enseignant.ID_Cours = :idCours";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([':idCours' => $idCours]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>