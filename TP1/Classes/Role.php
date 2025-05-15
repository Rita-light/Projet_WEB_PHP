<?php
class Role {
    private $id;
    private $nom;

    public function __construct($id = null, $nom = null) {
        $this->id = $id;
        $this->nom = $nom;
    }

    public function create($dbConnection) {
        $query = "INSERT INTO Role (Nom) VALUES (:nom)";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([':nom' => $this->nom]);
    }

    public function read($dbConnection, $id) {
        $query = "SELECT * FROM Role WHERE ID = :id";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>