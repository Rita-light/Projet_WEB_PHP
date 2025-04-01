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

    public function delete($dbConnection) {
        $query = "DELETE FROM " . $this->getType() . " WHERE ID = :id";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([':id' => $this->id]);
    }
}
?>