<?php
require_once 'Individu.php';

class Etudiant extends Individu {
    private $numeroDA;
    private $dateInscription;
    private $password;

    public function __construct($id, $nom, $prenom, $dateNaissance, $email, $numeroDA, $dateInscription, $password) {
        parent::__construct($id, $nom, $prenom, $dateNaissance, $email);
        $this->numeroDA = $numeroDA;
        $this->dateInscription = $dateInscription;
        $this->password = $password;
    }

    public function getType() {
        return 'Etudiant';
    }

    public function create($dbConnection) {
        $query = "INSERT INTO Etudiant (NumeroDA, Nom, Prenom, DateNaissance, Email, DateInscription, Password) 
                  VALUES (:numeroDA, :nom, :prenom, :dateNaissance, :email, :dateInscription, :password)";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([
            ':numeroDA' => $this->numeroDA,
            ':nom' => $this->nom,
            ':prenom' => $this->prenom,
            ':dateNaissance' => $this->dateNaissance,
            ':email' => $this->email,
            ':dateInscription' => $this->dateInscription,
            ':password' => $this->password,
        ]);
    }

    public static function readAll($dbConnection) {
        $query = "SELECT * FROM Etudiant";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>