<?php
class CoursEtudiant {
    private $idCours;
    private $idEtudiant;

    public function __construct($idCours, $idEtudiant) {
        $this->idCours = $idCours;
        $this->idEtudiant = $idEtudiant;
    }

    // Ajouter un étudiant à un cours
    public function assign($dbConnection) {
        $query = "INSERT INTO Cours_Etudiant (ID_Cours, ID_Etudiant) VALUES (:idCours, :idEtudiant)";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([
            ':idCours' => $this->idCours,
            ':idEtudiant' => $this->idEtudiant,
        ]);
    }

    // Lire tous les étudiants inscrits dans un cours donné
    public static function readByCours($dbConnection, $idCours) {
        $query = "SELECT * FROM Etudiant 
                  INNER JOIN Cours_Etudiant ON Etudiant.ID = Cours_Etudiant.ID_Etudiant
                  WHERE Cours_Etudiant.ID_Cours = :idCours";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([':idCours' => $idCours]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Supprimer un étudiant d'un cours
    public static function delete($dbConnection, $idCours, $idEtudiant) {
        $query = "DELETE FROM Cours_Etudiant WHERE ID_Cours = :idCours AND ID_Etudiant = :idEtudiant";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([
            ':idCours' => $idCours,
            ':idEtudiant' => $idEtudiant,
        ]);
    }
}
?>