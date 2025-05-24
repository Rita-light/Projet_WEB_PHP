<?php
class Groupe {
    private $id;
    private $numero;
    private $nom;
    private $description;
    private $idCours;

    public function __construct($id = null, $numero = null, $nom = null, $description = null, $idCours = null) {
        $this->id = $id;
        $this->numero = $numero;
        $this->nom = $nom;
        $this->description = $description;
        $this->idCours = $idCours;
    }

    public function create($dbConnection) {
        $query = "INSERT INTO Groupe (Numero, Nom, Description, ID_Cours) VALUES (:numero, :nom, :description, :idCours)";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([
            ':numero' => $this->numero,
            ':nom' => $this->nom,
            ':description' => $this->description,
            ':idCours' => $this->idCours,
        ]);
    }

    public static function readAll($dbConnection) {
        $query = "SELECT * FROM Groupe";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTousLesGroupes($db) {
        $query = "SELECT ID, Nom FROM Groupe";
        
        $stmt = $db->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function update($dbConnection) {
        $query = "UPDATE Groupe SET Numero = :numero, Nom = :nom, Description = :description, ID_Cours = :idCours WHERE ID = :id";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([
            ':numero' => $this->numero,
            ':nom' => $this->nom,
            ':description' => $this->description,
            ':idCours' => $this->idCours,
            ':id' => $this->id,
        ]);
    }

    public static function delete($dbConnection, $id) {
        $query = "DELETE FROM Groupe WHERE ID = :id";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([':id' => $id]);
    }


    public static function getGroupsByDepartement($db, $departementId) {
        $query = "
            SELECT Groupe.ID, Groupe.Nom AS Nom
            FROM Groupe
            JOIN Cours ON Groupe.ID_Cours = Cours.ID
            WHERE Cours.ID_Departement = :departementId
        ";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':departementId', $departementId, PDO::PARAM_INT); // Ensure proper type
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Return the result as an associative array
    }

    public static function getIdCoursParGroupe($db, $idGroupe) {
        $query = "SELECT ID_Cours FROM Groupe WHERE ID = :idGroupe";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':idGroupe', $idGroupe, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['ID_Cours'] : null;
    }


}
?>