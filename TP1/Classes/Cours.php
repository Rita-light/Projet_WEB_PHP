<?php
class Cours {
    private $id;
    private $numero;
    private $nom;
    private $description;
    private $idDepartement;

    public function __construct($id = null, $numero = null, $nom = null, $description = null, $idDepartement = null) {
        $this->id = $id;
        $this->numero = $numero;
        $this->nom = $nom;
        $this->description = $description;
        $this->idDepartement = $idDepartement;
    }

    public function create($dbConnection) {
        $query = "INSERT INTO Cours (Numero, Nom, Description, ID_Departement) VALUES (:numero, :nom, :description, :idDepartement)";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([
            ':numero' => $this->numero,
            ':nom' => $this->nom,
            ':description' => $this->description,
            ':idDepartement' => $this->idDepartement,
        ]);
        $this->id = $dbConnection->lastInsertId();
    }

    public static function readAll($dbConnection) {
        $query = "SELECT * FROM Cours";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($dbConnection) {
        $query = "UPDATE Cours SET Numero = :numero, Nom = :nom, Description = :description, ID_Departement = :idDepartement WHERE ID = :id";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([
            ':numero' => $this->numero,
            ':nom' => $this->nom,
            ':description' => $this->description,
            ':idDepartement' => $this->idDepartement,
            ':id' => $this->id,
        ]);
    }

    public static function delete($dbConnection, $id) {
        $query = "DELETE FROM Cours WHERE ID = :id";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([':id' => $id]);
    }

    public static function getCoursByID($dbConnection, $departementId){
        $queryCours = "
            SELECT ID, Nom 
            FROM Cours 
            WHERE ID_Departement = :departementId
        ";
        $stmtCours = $dbConnection->prepare($queryCours);
        $stmtCours->bindValue(':departementId', $departementId);
        $stmtCours->execute();
        $coursOptions = $stmtCours->fetchAll(PDO::FETCH_ASSOC);

        return $coursOptions;
    }
    
    public static function getAll($db) {
        $sql = "SELECT * FROM Cours";
        return $db->query($sql)->fetchAll();
    }
}
?>