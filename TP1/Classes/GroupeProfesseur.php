<?php

class GroupeProfesseur {
    private $idGroupe;
    private $idProfesseur;

    public function __construct($idGroupe, $idProfesseur) {
        $this->idGroupe = $idGroupe;
        $this->idProfesseur = $idProfesseur;
    }

    // Assigner un professeur à un groupe
    public static function assign($dbConnection, $idGroupe, $idProfesseurAssoc) {
        $queryCheckProf = "
            SELECT ID 
            FROM Groupe_Professeur
            WHERE ID_Groupe = :idGroupe
        ";
        $stmtCheckProf = $dbConnection->prepare($queryCheckProf);
        $stmtCheckProf->bindValue(':idGroupe', $idGroupe);
        $stmtCheckProf->execute();
        $professeurExistant = $stmtCheckProf->fetch();

        if (!$professeurExistant) {
            $queryAddProfesseur = "
                INSERT INTO Groupe_Professeur (ID_Groupe, ID_Professeur)
                VALUES (:idGroupe, :idProfesseur)
            ";
            $stmtAddProfesseur = $dbConnection->prepare($queryAddProfesseur);
            $stmtAddProfesseur->bindValue(':idGroupe', $idGroupe);
            $stmtAddProfesseur->bindValue(':idProfesseur', $idProfesseurAssoc);
            $stmtAddProfesseur->execute();
        } else {
            die("Erreur : Ce groupe a déjà un professeur.");
        }
    }

    // Lire tous les groupes assignés à un professeur donné
    public static function readByProfesseur($dbConnection, $idProfesseur) {
        $query = "SELECT * FROM Groupe 
                  INNER JOIN Groupe_Professeur ON Groupe.ID = Groupe_Professeur.ID_Groupe
                  WHERE Groupe_Professeur.ID_Professeur = :idProfesseur";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([':idProfesseur' => $idProfesseur]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Supprimer l'association entre un groupe et un professeur
    public static function delete($dbConnection, $idGroupe, $idProfesseur) {
        $query = "DELETE FROM Groupe_Professeur WHERE ID_Groupe = :idGroupe AND ID_Professeur = :idProfesseur";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([
            ':idGroupe' => $idGroupe,
            ':idProfesseur' => $idProfesseur,
        ]);
    }


    /*public static function getAssociationsByDepartement($db, $departementId) {
        $query = "
            SELECT Groupe.Nom AS NomGroupe, 
                   CONCAT(Professeur.Nom, ' ', Professeur.Prenom) AS NomProfesseur
            FROM Groupe_Professeur
            JOIN Groupe ON Groupe_Professeur.ID_Groupe = Groupe.ID
            JOIN Professeur ON Groupe_Professeur.ID_Professeur = Professeur.ID
            JOIN Cours ON Groupe.ID_Cours = Cours.ID
            WHERE Cours.ID_Departement = :departementId
        ";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':departementId', $departementId, PDO::PARAM_INT); // Ensure parameter type matches
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Return the result as an associative array
    }*/

    public static function getAssociationsByDepartement($db, $departementId) {
    $query = "
        SELECT Groupe.Nom AS NomGroupe, 
               CONCAT(Utilisateur.Nom, ' ', Utilisateur.Prenom) AS NomProfesseur
        FROM Groupe_Professeur
        JOIN Groupe ON Groupe_Professeur.ID_Groupe = Groupe.ID
        JOIN Professeur ON Groupe_Professeur.ID_Professeur = Professeur.ID
        JOIN Utilisateur ON Professeur.ID = Utilisateur.ID
        JOIN Cours ON Groupe.ID_Cours = Cours.ID
        WHERE Cours.ID_Departement = :departementId
    ";
    
    $stmt = $db->prepare($query);
    $stmt->bindValue(':departementId', $departementId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}
?>