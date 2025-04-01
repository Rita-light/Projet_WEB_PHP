<?php
require_once '../FichierPHP/verifierConnexionEnseignant.php';
require_once '../config/db.php'; // Inclure la connexion à la base de données
require_once '../Classes/Professeur.php'; // Inclure la classe Professeur



// Vérifiez si l'enseignant est connecté
if (!isset($_SESSION['enseignant_id'])) {
    die("Erreur : ID enseignant non défini. Veuillez vous reconnecter.");
}

$idProfesseur = $_SESSION['enseignant_id']; // ID de l'enseignant connecté

try {
   
    // Récupère uniquement les groupes auxquels l'enseignant donne cours
    $query = "
        SELECT Groupe.Numero AS NumeroGroupe, Groupe.Nom AS NomGroupe
        FROM Groupe_Professeur
        JOIN Groupe ON Groupe_Professeur.ID_Groupe = Groupe.ID
        WHERE Groupe_Professeur.ID_Professeur = :idProfesseur
        ORDER BY Groupe.Numero;
    ";
    $stmt = $dbConnection->prepare($query);
    $stmt->bindValue(':idProfesseur', $idProfesseur);
    $stmt->execute();
    $groupes = $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourne les données sous forme de tableau associatif
} catch (PDOException $e) {
    die("Erreur lors de la récupération des groupes : " . $e->getMessage());
}
?>