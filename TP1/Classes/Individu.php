<?php
abstract class Individu {
    protected $id;
    protected $nom;
    protected $prenom;
    protected $dateNaissance;
    protected $email;

    public function __construct($id, $nom, $prenom, $dateNaissance, $email) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateNaissance = $dateNaissance;
        $this->email = $email;
    }

    abstract public function getType();

    public function getNomComplet() {
        return $this->prenom . ' ' . $this->nom;
    }

    public function update($dbConnection) {
        $query = "UPDATE " . $this->getType() . " SET Nom = :nom, Prenom = :prenom, DateNaissance = :dateNaissance, Email = :email WHERE ID = :id";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([
            ':nom' => $this->nom,
            ':prenom' => $this->prenom,
            ':dateNaissance' => $this->dateNaissance,
            ':email' => $this->email,
            ':id' => $this->id,
        ]);
    }

    public function delete($dbConnection) {
        $query = "DELETE FROM " . $this->getType() . " WHERE ID = :id";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([':id' => $this->id]);
    }
}
?>