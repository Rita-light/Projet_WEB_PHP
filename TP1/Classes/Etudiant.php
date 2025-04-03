<?php
require_once 'Individu.php';

class Etudiant extends Individu {
    private $numeroDA;
    private $dateInscription;
    private $password;
    private $avatar;

    public function __construct($id, $nom, $prenom, $dateNaissance, $email, $numeroDA, $dateInscription, $password, $avatar) {
        parent::__construct($id, $nom, $prenom, $dateNaissance, $email);
        $this->numeroDA = $numeroDA;
        $this->dateInscription = $dateInscription;
        $this->password = $password;
        $this->avatar = $avatar;
    }

    public function getType() {
        return 'Etudiant';
    }

    /**
     * Methode qui permet de creer et d'ajouter un nouvel étudiant dans la bd
     */
    public function create($dbConnection, $avatarFile) {
        // Étape 1 : insérer sans NumeroDA
        $query = "INSERT INTO Etudiant (Nom, Prenom, DateNaissance, Email, DateInscription, Password) 
                  VALUES (:nom, :prenom, :dateNaissance, :email, :dateInscription, :password)";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute([
            ':nom' => $this->nom,
            ':prenom' => $this->prenom,
            ':dateNaissance' => $this->dateNaissance,
            ':email' => $this->email,
            ':dateInscription' => $this->dateInscription,
            ':password' => $this->password,
        ]);
    
        // Étape 2 : récupérer l'ID généré
        $id = $dbConnection->lastInsertId();
        $this->id = $id;
        $this->numeroDA = 'DA' . str_pad($id, 3, '0', STR_PAD_LEFT);
    
        // Étape 3 : mettre à jour le champ NumeroDA
        $updateQuery = "UPDATE Etudiant SET NumeroDA = :numeroDA WHERE ID = :id";
        $stmt = $dbConnection->prepare($updateQuery);
        $stmt->execute([
            ':numeroDA' => $this->numeroDA,
            ':id' => $id,
        ]);
    
        // Étape 4 : gérer l’avatar
        if ($avatarFile && $avatarFile['tmp_name']) {
            // La fonction uploadAvatar retourne le chemin du fichier avatar
            $avatarPath = $this->uploadAvatar($avatarFile);
        
            // Étape 5 : mettre à jour le champ Avatar dans la base de données
            $updateAvatarQuery = "UPDATE Etudiant SET Avatar = :avatarPath WHERE ID = :id";
            $stmtAvatar = $dbConnection->prepare($updateAvatarQuery);
            $stmtAvatar->execute([
                ':avatarPath' => $avatarPath,
                ':id' => $id,
            ]);
        }

    
        return $this->numeroDA; // Retourne le DA généré
    }
    

    public static function readAll($dbConnection) {
        $query = "SELECT * FROM Etudiant";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function readByNumeroDA($dbConnection, $numeroDA) {
        $query = "SELECT Nom, Prenom, DateNaissance, Email, Avatar FROM Etudiant WHERE NumeroDA = :numeroDA";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindValue(':numeroDA', $numeroDA);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne un tableau associatif avec les données
    }



    public static function updateByNumeroDA($dbConnection, $numeroDA, $nom, $prenom, $email, $dateNaissance, $avatarFile = null) {
        if ($avatarFile && $avatarFile['error'] === UPLOAD_ERR_OK) 
        { 
            $etudiant = new Etudiant(null, null, null, null,null, $numeroDA, null, null, null); // Instanciez l'objet Étudiant pour accéder à la méthode d'upload 
            $avatarPath = $etudiant->uploadAvatar($avatarFile); 
            $query = "UPDATE Etudiant SET Avatar = :avatar WHERE NumeroDA = :numeroDA";
            $stmt = $dbConnection->prepare($query);
            $stmt->bindValue(':avatar', $avatarPath);
            $stmt->bindValue(':numeroDA', $numeroDA);
            $stmt->execute();
        }
        
        $query = "
            UPDATE Etudiant
            SET Nom = :nom, Prenom = :prenom, DateNaissance = :dateNaissance, Email =:email
            WHERE NumeroDA = :numeroDA
        ";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindValue(':nom', $nom);
        $stmt->bindValue(':prenom', $prenom);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':dateNaissance', $dateNaissance);
        $stmt->bindValue(':numeroDA', $numeroDA);
        return $stmt->execute();
    
    }

    // Supprimer un étudiant
    public static function deleteByNumeroDA($dbConnection, $numeroDA) {
        $query = "DELETE FROM Etudiant WHERE NumeroDA = :numeroDA";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindValue(':numeroDA', $numeroDA);
        $isExecute = $stmt->execute();

        // Supprimer également l'avatar (fichier image)
        $avatarPath = 'avatars/DA' . $numeroDA . '.jpg';
        if (file_exists($avatarPath)) {
            unlink($avatarPath);  // Supprimer l'image de l'avatar
        }

        return $isExecute;
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

        // Supprimer l'ancienne photo de profil si elle existe
        $oldAvatar = glob($avatarDir . $this->numeroDA . '.*'); 
        if (!empty($oldAvatar)) {
            unlink($oldAvatar[0]); // Supprime l'ancien fichier
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