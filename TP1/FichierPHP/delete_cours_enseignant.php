<?php
require_once '../config/db.php'; 
require_once '../Classes/CoursEnseignant.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['association_id'])) {
        $associationID = $_POST['association_id']; // Récupérer l'identifiant de l'association

        try {
            // Préparer et exécuter la requête de suppression
            $rowCount = CoursEnseignant::delete($dbConnection, $associationID);

            if ($rowCount > 0) {
                // Redirection avec un message de succès
                echo "<script>
                        alert('L\'association cours-enseignant a été supprimée avec succès.');
                        window.location.href = '../FichierHTML/gestion_cours_enseignant.php';
                      </script>";
            } else {
                // Si aucune ligne n'a été affectée (par exemple, mauvais ID)
                echo "<script>
                        alert('Erreur : Association introuvable ou déjà supprimée.');
                        window.history.back();
                      </script>";
            }
        } catch (PDOException $e) {
            // Gestion des erreurs liées à la base de données
            echo "<script>
                    alert('Erreur lors de la suppression : " . $e->getMessage() . "');
                    window.history.back();
                  </script>";
        }
    } else {
        // Si l'ID n'est pas fourni
        echo "<script>
                alert('Erreur : ID de l\'association non fourni.');
                window.history.back();
              </script>";
    }
} else {
    // Accès direct interdit
    echo "<script>
            alert('Accès non autorisé.');
            window.history.back();
          </script>";
}