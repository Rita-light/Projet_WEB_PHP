<?php
class GroupeEtudiant {
    private $idGroupe;
    private $idEtudiant;

    public function __construct($idGroupe, $idEtudiant) {
        $this->idGroupe = $idGroupe;
        $this->idEtudiant = $idEtudiant;
    }

    public function create($dbConnection) {
        $query = "INSERT INTO Groupe_Etudiant (ID_Groupe, ID_Etudiant) VALUES (:idGroupe, :idEtudiant)";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([
            ':idGroupe' => $this->idGroupe,
            ':idEtudiant' => $this->idEtudiant,
        ]);
    }

    /**
     * Assigne un étudiant à un groupe après vérifications.
     *
     * Cette méthode vérifie d'abord si l'étudiant est inscrit au cours du groupe.
     * Ensuite, elle s'assure que l'étudiant n'est pas déjà dans un autre groupe pour ce cours.
     * Si ces conditions sont remplies, l'étudiant est ajouté au groupe.
     *
     * @param PDO $dbConnection Connexion à la base de données.
     * @param int $idEtudiant Identifiant de l'étudiant.
     * @param int $idGroupe Identifiant du groupe.
     * @return void
     */
    public static function assign($dbConnection, $idEtudiant, $idGroupe){
        // Vérifier si l'étudiant est inscrit au cours du groupe
        $queryCheckCours = "
            SELECT Cours_Etudiant.ID_Cours
            FROM Cours_Etudiant
            JOIN Groupe ON Groupe.ID_Cours = Cours_Etudiant.ID_Cours
            WHERE Groupe.ID = :idGroupe AND Cours_Etudiant.ID_Etudiant = :idEtudiant
        ";
        $stmtCheckCours = $dbConnection->prepare($queryCheckCours);
        $stmtCheckCours->bindValue(':idGroupe', $idGroupe);
        $stmtCheckCours->bindValue(':idEtudiant', $idEtudiant);
        $stmtCheckCours->execute();
        $isInscrit = $stmtCheckCours->fetch();

        if (!$isInscrit) {
            die("Erreur : L'étudiant n'est pas inscrit au cours de ce groupe.");
        }

        // Vérifier si l'étudiant est déjà dans un autre groupe pour ce cours
        $queryCheckGroupe = "
            SELECT Groupe_Etudiant.ID
            FROM Groupe_Etudiant
            JOIN Groupe ON Groupe_Etudiant.ID_Groupe = Groupe.ID
            WHERE Groupe.ID_Cours = (
                SELECT ID_Cours FROM Groupe WHERE ID = :idGroupe
            ) AND Groupe_Etudiant.ID_Etudiant = :idEtudiant
        ";
        $stmtCheckGroupe = $dbConnection->prepare($queryCheckGroupe);
        $stmtCheckGroupe->bindValue(':idGroupe', $idGroupe);
        $stmtCheckGroupe->bindValue(':idEtudiant', $idEtudiant);
        $stmtCheckGroupe->execute();
        $alreadyInGroupe = $stmtCheckGroupe->fetch();

        if ($alreadyInGroupe) {
            echo "<script>
                alert(\"Erreur : L'étudiant appartient déjà à un autre groupe pour ce cours.\");
                window.location.href = '../FichierHTML/gestion_groupe_etudiant.php';
            </script>";
        }

        // Ajouter l'association
        $queryAdd = "
            INSERT INTO Groupe_Etudiant (ID_Groupe, ID_Etudiant)
            VALUES (:idGroupe, :idEtudiant)
        ";
        $stmtAdd = $dbConnection->prepare($queryAdd);
        $stmtAdd->bindValue(':idGroupe', $idGroupe);
        $stmtAdd->bindValue(':idEtudiant', $idEtudiant);
        $stmtAdd->execute();

    }

    public static function readByGroupe($dbConnection, $idGroupe) {
        $query = "SELECT * FROM Etudiant 
                  INNER JOIN Groupe_Etudiant ON Etudiant.ID = Groupe_Etudiant.ID_Etudiant
                  WHERE Groupe_Etudiant.ID_Groupe = :idGroupe";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([':idGroupe' => $idGroupe]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function delete($dbConnection, $idGroupe, $idEtudiant) {
        $query = "DELETE FROM Groupe_Etudiant WHERE ID_Groupe = :idGroupe AND ID_Etudiant = :idEtudiant";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([
            ':idGroupe' => $idGroupe,
            ':idEtudiant' => $idEtudiant,
        ]);
    }

    public static function getAssociationsByDepartement($db, $departementId) {
        $query = "
            SELECT G.Nom AS GroupeNom, 
                U.Nom, 
                U.Prenom
            FROM Groupe_Etudiant GE
            JOIN Groupe G ON GE.ID_Groupe = G.ID
            JOIN Cours C ON G.ID_Cours = C.ID
            JOIN Etudiant E ON GE.ID_Etudiant = E.ID
            JOIN Utilisateur U ON E.ID = U.ID
            WHERE C.ID_Departement = :departementId
            ORDER BY G.Nom, U.Nom
        ";
        
        $stmt = $db->prepare($query);
        $stmt->bindValue(':departementId', $departementId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAllAssociations($db) {
        $query = "
            SELECT G.Nom AS GroupeNom, 
                U.Nom, 
                U.Prenom
            FROM Groupe_Etudiant GE
            JOIN Groupe G ON GE.ID_Groupe = G.ID
            JOIN Cours C ON G.ID_Cours = C.ID
            JOIN Etudiant E ON GE.ID_Etudiant = E.ID
            JOIN Utilisateur U ON E.ID = U.ID
            ORDER BY G.Nom, U.Nom
        ";
        
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



}
?>