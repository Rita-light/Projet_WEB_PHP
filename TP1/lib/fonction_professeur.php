<?php

function getAllEnseignants($db) {
    $sql = "SELECT u.ID, u.Nom, u.Prenom, p.DateEmbauche, d.Nom AS Departement
            FROM Professeur p
            JOIN Utilisateur u ON u.ID = p.ID
            LEFT JOIN Departement d ON p.ID_Departement = d.ID";
    $stmt = $db->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
}

function getEnseignant($db, $id) {
    $stmt = $db->prepare("SELECT u.ID, u.Nom, u.Prenom, p.DateEmbauche, d.Nom AS Departement
                          FROM Professeur p
                          JOIN Utilisateur u ON u.ID = p.ID
                          LEFT JOIN Departement d ON p.ID_Departement = d.ID
                          WHERE u.ID = ?");
    $stmt->execute([$id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo $result ? json_encode($result) : json_encode(['error' => 'Enseignant non trouvé']);
}

function addEnseignant($db) {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data['Nom'], $data['Prenom'], $data['DateNaissance'], $data['Email'], $data['Password'], $data['DateEmbauche'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Champs manquants']);
        return;
    }

    $db->beginTransaction();

    try {
        $stmt = $db->prepare("INSERT INTO Utilisateur (Nom, Prenom, DateNaissance, Email, Password) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['Nom'], $data['Prenom'], $data['DateNaissance'],
            $data['Email'], password_hash($data['Password'], PASSWORD_DEFAULT)
        ]);

        $idUtilisateur = $db->lastInsertId();

        $stmt2 = $db->prepare("INSERT INTO Professeur (ID, DateEmbauche, ID_Departement) VALUES (?, ?, ?)");
        $stmt2->execute([
            $idUtilisateur, $data['DateEmbauche'], $data['ID_Departement'] ?? null
        ]);

        $db->commit();
                echo json_encode([
            'success' => true,
            'message' => 'Enseignant ajouté avec succès',
            'id' => $idUtilisateur
        ]);


    } catch (PDOException $e) {
        $db->rollBack();
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}

function updateEnseignant($db, $id) {
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $db->prepare("UPDATE Utilisateur SET Nom = ?, Prenom = ? WHERE ID = ?");
    $stmt->execute([$data['Nom'], $data['Prenom'], $id]);

    $stmt2 = $db->prepare("UPDATE Professeur SET DateEmbauche = ?, ID_Departement = ? WHERE ID = ?");
    $stmt2->execute([$data['DateEmbauche'], $data['ID_Departement'], $id]);

    echo json_encode([
        'success' => true,
        'message' => 'Enseignant mis a jour avec succes'
    ]);
}

function deleteEnseignant($db, $id) {
    $stmt = $db->prepare("DELETE FROM Utilisateur WHERE ID = ?");
    $stmt->execute([$id]);
    echo json_encode([
        'success' => true,
        'message' => 'Enseignant supprime avec succes'
    ]);
}
