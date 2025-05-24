<?php
require_once(__DIR__ . '/Utilisateur.php');


class Etudiant extends Utilisateur {
    private $numeroDA;
    private $dateInscription;
    private $avatar;

    public function __construct($id, $nom, $prenom, $dateNaissance, $email, $password, $numeroDA = null , $dateInscription = null,  $avatar = null) {
        parent::__construct($id, $nom, $prenom, $dateNaissance, $email, $password);
        $this->numeroDA = $numeroDA;
        $this->dateInscription = $dateInscription;
        $this->avatar = $avatar;
    }


    /**
     * Methode qui permet de creer et d'ajouter un nouvel étudiant dans la bd
     */
    public function create($dbConnection, $avatarFile = NULL) {

        // Étape 1 : insérer dans Utilisateur, recuper ID et créer DA
        $this->id = parent::create($dbConnection);
        $this->numeroDA = 'DA' . str_pad($this->id, 3, '0', STR_PAD_LEFT);

        // Étape 1 : insérer sans NumeroDA
        $query = "INSERT INTO Etudiant ( ID, DateInscription, NumeroDA ) 
                  VALUES ( :id, :dateInscription, :numeroDA )";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([
            ':id' => $this->id,
            ':dateInscription' => $this->dateInscription,
            ':numeroDA' => $this->numeroDA,
        ]);
    
    
    
        // Étape 2 : gérer l’avatar
        if ($avatarFile && $avatarFile['tmp_name']) {
            // La fonction uploadAvatar retourne le chemin du fichier avatar
            $avatarPath = $this->uploadAvatar($avatarFile);
        
            // Étape 5 : mettre à jour le champ Avatar dans la base de données
            $updateAvatarQuery = "UPDATE Etudiant SET Avatar = :avatarPath WHERE ID = :id";
            $stmtAvatar = $dbConnection->prepare($updateAvatarQuery);
            $stmtAvatar->execute([
                ':avatarPath' => $avatarPath,
                ':id' => $this->id,
            ]);
        }

        // Étape 3 : ajouter le rôle Étudiant
        $this->ajouterRole($dbConnection, 'Étudiant');
    
        return $this->numeroDA; // Retourne le DA généré
    }
    

    public static function readAll($dbConnection) {
        $query = "
            SELECT 
                u.ID, e.NumeroDA, u.Nom, u.Prenom, u.Email, u.DateNaissance, 
                 e.DateInscription, e.Avatar, e.NumeroDA
            FROM Etudiant e
            INNER JOIN Utilisateur u ON e.ID = u.ID
        ";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }   


    public static function readById($dbConnection, $id) {
        $query = "
            SELECT u.Nom, u.Prenom, u.DateNaissance, u.Email, e.Avatar, e.NumeroDA
            FROM Utilisateur u
            INNER JOIN Etudiant e ON u.ID = e.ID
            WHERE u.ID = :id
        ";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public static function updateById($dbConnection, $id, $nom, $prenom, $email, $dateNaissance, $numeroDA, $avatarFile = null) {
        // Met à jour l'avatar si fourni
        if ($avatarFile && $avatarFile['error'] === UPLOAD_ERR_OK) {
            $etudiant = new Etudiant($id, $nom, $prenom, $dateNaissance, $email, '',$numeroDA, null, null);
            $avatarPath = $etudiant->uploadAvatar($avatarFile);

            $query = "UPDATE Etudiant SET Avatar = :avatar WHERE ID = :id";
            $stmt = $dbConnection->prepare($query);
            $stmt->bindValue(':avatar', $avatarPath);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        }

        // Mise à jour des données dans la table Utilisateur
        $query = "
            UPDATE Utilisateur
            SET Nom = :nom, Prenom = :prenom, Email = :email, DateNaissance = :dateNaissance
            WHERE ID = :id
        ";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindValue(':nom', $nom);
        $stmt->bindValue(':prenom', $prenom);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':dateNaissance', $dateNaissance);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function deleteById($dbConnection, $id) {
        // Récupération du chemin de l'avatar avant suppression
        $query = "SELECT Avatar FROM Etudiant WHERE ID = :id";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && !empty($result['Avatar']) && file_exists($result['Avatar'])) {
            unlink($result['Avatar']);
        }

        // Suppression de l'utilisateur (cascade supprimera aussi l'étudiant et les rôles)
        $query = "DELETE FROM Utilisateur WHERE ID = :id";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }


    public static function getCoursEtGroupe($dbConnection, $idEtudiant) {
        $query = "
           SELECT 
                IFNULL(Cours.Nom, 'Aucun cours trouvé') AS NomCours,
                IFNULL(Cours.Description, '') AS Description,
                IFNULL(Departement.Nom, '') AS Departement,
                IFNULL(Groupe.Numero, 'Pas affecté') AS Groupe
            FROM 
                Cours_Etudiant
            JOIN 
                Cours ON Cours_Etudiant.ID_Cours = Cours.ID
            JOIN 
                Departement ON Cours.ID_Departement = Departement.ID
            LEFT JOIN 
                Groupe_Etudiant ON Groupe_Etudiant.ID_Etudiant = Cours_Etudiant.ID_Etudiant
                            AND Groupe_Etudiant.ID_Groupe IN (
                                SELECT ID 
                                FROM Groupe 
                                WHERE Groupe.ID_Cours = Cours.ID
                            )
            LEFT JOIN 
                Groupe ON Groupe.ID = Groupe_Etudiant.ID_Groupe
            WHERE 
                Cours_Etudiant.ID_Etudiant = :idEtudiant;
        ";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindValue(':idEtudiant', $idEtudiant);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourne les résultats sous forme de tableau associatif
    }

    // Méthode pour télécharger l'avatar de l'étudiant
    private function uploadAvatar($avatarFile) {
        // Liste des extensions de fichiers autorisées
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'svg'];
        
        // Extraire l'extension du fichier
        $fileExtension = strtolower(pathinfo($avatarFile['name'], PATHINFO_EXTENSION));
        
        // Vérifier si l'extension est autorisée
        if (!in_array($fileExtension, $allowedExtensions)) {
            throw new Exception('Format de fichier non supporté. Veuillez télécharger une image (JPG, PNG, GIF, SVG).');
        }
        
        // Dossier où les avatars sont stockés
        $avatarDir = '../avatars/';
        $avatarPath = $avatarDir . $this->numeroDA . '.' . $fileExtension;  // Nom du fichier avec le numéro de DA et l'extension

        /*if (!empty($oldAvatar) && is_file($oldAvatar[0])) {
            unlink($oldAvatar[0]); // Supprime l'ancien fichier uniquement s'il existe
        } */

        // Supprimer tous les anciens avatars de l'étudiant (même DA, autres extensions)
        foreach ($allowedExtensions as $ext) {
            $oldPath = $avatarDir . $this->numeroDA . '.' . $ext;
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }



        // Déplacer le fichier téléchargé vers le répertoire de stockage
        if (move_uploaded_file($avatarFile['tmp_name'], $avatarPath)) {
            return $avatarPath;  // Retourner le chemin du fichier
        } else {
            throw new Exception('Une erreur est survenue lors de l\'upload de l\'avatar.');
        }
    }

}
?>