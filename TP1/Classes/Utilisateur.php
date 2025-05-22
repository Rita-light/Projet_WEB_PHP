<?php
require_once (__DIR__ . '/../lib/Security.php');

class Utilisateur {
    protected $id;
    protected $nom;
    protected $prenom;
    protected $dateNaissance;
    protected $email;
    protected $password;

    public function __construct($id, $nom, $prenom, $dateNaissance, $email, $password) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateNaissance = $dateNaissance;
        $this->email = $email;
        $this->password = (new Security())->hashPassword($password);
    }

    public function create($dbConnection) {
        $sql = "INSERT INTO Utilisateur (nom, prenom, dateNaissance, email, password) VALUES (:nom, :prenom, :dateNaissance, :email, :password)";
        $stmt = $dbConnection->prepare($sql);
        $stmt->execute([
            ':nom' => $this->nom,
            ':prenom' => $this->prenom,
            ':dateNaissance' => $this->dateNaissance,
            ':email' => $this->email,
            ':password' => $this->password,
        ]);

        $this->id = $dbConnection->lastInsertId();
        return $this->id;
    }

    public function getId() {
        return $this->id;
    }

    public static function read($dbConnection, $id) {
        $sql = "SELECT * FROM Utilisateur WHERE ID = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

     

    public function getNomComplet() {
        return $this->prenom . ' ' . $this->nom;
    }

    /*public function delete($dbConnection) {
        $query = "DELETE FROM " . $this->getType() . " WHERE ID = :id";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([':id' => $this->id]);
    }*/

    public function update($dbConnection) {
        $sql = "UPDATE Utilisateur SET nom = :nom, prenom = :prenom, dateNaissance = :dateNaissance, email = :email, password = :password WHERE ID = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':id' => $this->id,
            ':nom' => $this->nom,
            ':prenom' => $this->prenom,
            ':dateNaissance' => $this->dateNaissance,
            ':email' => $this->email,
            ':password' => $this->password,
        ]);
    }

    public static function delete($dbConnection) {
        $sql = "DELETE FROM Utilisateur WHERE ID = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $this->id]);
    }

    public static function getAll($dbConnection) {
        $sql = "SELECT * FROM Utilisateur";
        return $db->query($sql)->fetchAll();
    }

    /**
     * Ajouetr le role
     */
    public function ajouterRole($db, $nomRole) {

        // 1. Trouver l'ID du rôle
        $query = "SELECT ID FROM Role WHERE Nom = :nomRole";
        $stmt = $db->prepare($query);
        $stmt->execute([':nomRole' => $nomRole]);
        $role = $stmt->fetch();

        if (!$role) {
            throw new Exception("Le rôle '$nomRole' n'existe pas dans la table Role.");
        }

        $roleId = $role['ID'];

        // 2. Lier l'utilisateur au rôle
        $query = "INSERT IGNORE INTO Utilisateur_Role (ID_Utilisateur, ID_Role)
                VALUES (:idUtilisateur, :idRole)";
        $stmt = $db->prepare($query);
        $stmt->execute([
            ':idUtilisateur' => $this->id,
            ':idRole' => $roleId
        ]);

    }

}
?>