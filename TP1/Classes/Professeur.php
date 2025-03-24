<?php
require_once 'Individu.php';

class Professeur extends Individu {
    private $dateEmbauche;
    private $password;
    private $coordonnateur;

    public function __construct($id, $nom, $prenom, $dateNaissance, $email, $dateEmbauche, $password, $coordonnateur = false) {
        parent::__construct($id, $nom, $prenom, $dateNaissance, $email);
        $this->dateEmbauche = $dateEmbauche;
        $this->password = $password;
        $this->coordonnateur = $coordonnateur;
    }

    public function getType() {
        return 'Professeur';
    }

    public function create($dbConnection) {
        $query = "INSERT INTO Professeur (Nom, Prenom, DateNaissance, Email, DateEmbauche, Password, Coordonnateur) 
                  VALUES (:nom, :prenom, :dateNaissance, :email, :dateEmbauche, :password, :coordonnateur)";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([
            ':nom' => $this->nom,
            ':prenom' => $this->prenom,
            ':dateNaissance' => $this->dateNaissance,
            ':email' => $this->email,
            ':dateEmbauche' => $this->dateEmbauche,
            ':password' => $this->password,
            ':coordonnateur' => $this->coordonnateur,
        ]);
    }

    public static function readAll($dbConnection) {
        $query = "SELECT * FROM Professeur";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>