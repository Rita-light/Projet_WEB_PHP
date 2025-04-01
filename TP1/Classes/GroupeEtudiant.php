<?php
class GroupeEtudiant {
    private $idGroupe;
    private $idEtudiant;

    public function __construct($idGroupe, $idEtudiant) {
        $this->idGroupe = $idGroupe;
        $this->idEtudiant = $idEtudiant;
    }

    public function create($dbConnection) {
        $query = "INSERT INTO Groupe_Etudiant (ID_Groupe, ID_Etudiant) VALUES (:idGroupe, :idEtudiant)";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([
            ':idGroupe' => $this->idGroupe,
            ':idEtudiant' => $this->idEtudiant,
        ]);
    }

    public static function readByGroupe($dbConnection, $idGroupe) {
        $query = "SELECT * FROM Etudiant 
                  INNER JOIN Groupe_Etudiant ON Etudiant.ID = Groupe_Etudiant.ID_Etudiant
                  WHERE Groupe_Etudiant.ID_Groupe = :idGroupe";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([':idGroupe' => $idGroupe]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function delete($dbConnection, $idGroupe, $idEtudiant) {
        $query = "DELETE FROM Groupe_Etudiant WHERE ID_Groupe = :idGroupe AND ID_Etudiant = :idEtudiant";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([
            ':idGroupe' => $idGroupe,
            ':idEtudiant' => $idEtudiant,
        ]);
    }

    public static function getAssociationsByDepartement($db, $departementId) {
        $query = "
            SELECT G.Nom AS GroupeNom, 
                   E.Nom, 
                   E.Prenom
            FROM Groupe_Etudiant GE
            JOIN Groupe G ON GE.ID_Groupe = G.ID
            JOIN Cours C ON G.ID_Cours = C.ID
            JOIN Etudiant E ON GE.ID_Etudiant = E.ID
            WHERE C.ID_Departement = :departementId
            ORDER BY G.Nom, E.Nom
        ";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':departementId', $departementId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>