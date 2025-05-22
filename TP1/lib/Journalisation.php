<?php
function enregistrerEvenementConnexion($typeEvenement, $dbConnection, $idUtilisateur = null, $description = '') {
   
    $ip = $_SERVER['REMOTE_ADDR'];

    $sql = "INSERT INTO JournalConnexion (ID_Utilisateur, AdresseIP, TypeEvenement, Description)
            VALUES (:id_utilisateur, :ip, :type, :description)";
    
    $stmt = $dbConnection->prepare($sql);
    $stmt->execute([
        ':id_utilisateur' => $idUtilisateur,
        ':ip' => $ip,
        ':type' => $typeEvenement,
        ':description' => $description
    ]);
}
