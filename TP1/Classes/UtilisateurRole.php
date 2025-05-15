<?php
class UtilisateurRole {
    private $id;
    private $idUtilisateur;
    private $idRole;

    public function __construct($id = null, $idUtilisateur = null, $idRole = null) {
        $this->id = $id;
        $this->idUtilisateur = $idUtilisateur;
        $this->idRole = $idRole;
    }

    public function assignRole($dbConnection) {
        $query = "INSERT INTO Utilisateur_Role (ID_Utilisateur, ID_Role) VALUES (:idUtilisateur, :idRole)";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([
            ':idUtilisateur' => $this->idUtilisateur,
            ':idRole' => $this->idRole
        ]);
    }

    public static function read($dbConnection, $id) {
        $sql = "SELECT * FROM UtilisateurRole WHERE ID = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function removeRole($dbConnection) {
        $query = "DELETE FROM Utilisateur_Role WHERE ID_Utilisateur = :idUtilisateur AND ID_Role = :idRole";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([
            ':idUtilisateur' => $this->idUtilisateur,
            ':idRole' => $this->idRole
        ]);
    }

    public function getUserRoles($dbConnection) {
        $query = "SELECT Role.Nom FROM Utilisateur_Role 
                  JOIN Role ON Utilisateur_Role.ID_Role = Role.ID 
                  WHERE Utilisateur_Role.ID_Utilisateur = :idUtilisateur";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([':idUtilisateur' => $this->idUtilisateur]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>