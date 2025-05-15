<?php
class Departement {
    private ?int $id;
    private $code;
    private $nom;
    private $description;

    public function __construct(?int $id = null, $code = null, $nom = null, $description = null) {
        $this->id = $id;
        $this->code = $code;
        $this->nom = $nom;
        $this->description = $description;
    }

    public function create($dbConnection) {
        $query = "INSERT INTO Departement (Code, Nom, Description) VALUES (:code, :nom, :description)";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([
            ':code' => $this->code,
            ':nom' => $this->nom,
            ':description' => $this->description,
        ]);
        $this->id = (int) $dbConnection->lastInsertId();
    }

    public static function readAll($dbConnection) {
        $query = "SELECT * FROM Departement";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($dbConnection) {
        $query = "UPDATE Departement SET Code = :code, Nom = :nom, Description = :description WHERE ID = :id";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([
            ':code' => $this->code,
            ':nom' => $this->nom,
            ':description' => $this->description,
            ':id' => $this->id,
        ]);
    }

    public static function delete($dbConnection, $id) {
        $query = "DELETE FROM Departement WHERE ID = :id";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([':id' => $id]);
    }

    public function getId(): ?int {
        return $this->Id;
    }
}
?>