<?php
require_once '../FichierPHP/verifierConnexionEnseignant.php'; // Vérification session
require_once '../FichierPHP/gestCoursProfesseur.php'
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion Cours-Enseignants</title>
    <link rel="stylesheet" href="../FichierCSS/style2.css">
</head>
<body>
<header>
    <h1>Gérer les Associations Cours-Enseignants</h1>
</header>

<main>
    <h2>Liste des Associations</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Nom du Cours</th>
                <th>Nom de l’Enseignant</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($associations as $assoc): ?>
                <tr>
                    <td><?php echo htmlspecialchars($assoc['NomCours']); ?></td>
                    <td><?php echo htmlspecialchars($assoc['NomEnseignant']); ?></td>
                    <td>
                        <form method="POST" action="delete_cours_enseignant.php">
                            <input type="hidden" name="association_id" value="<?php echo htmlspecialchars($assoc['AssociationID']); ?>">
                            <input type="submit" value="Supprimer">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Ajouter une Association</h2>
    <form method="POST" action="">
        <label for="cours">Cours :</label>
        <select name="cours" id="cours" required>
            <option value="">-- Sélectionnez un cours --</option>
            <?php foreach ($coursOptions as $cours): ?>
                <option value="<?php echo htmlspecialchars($cours['ID']); ?>">
                    <?php echo htmlspecialchars($cours['Nom']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <label for="enseignant">Enseignant :</label>
        <select name="enseignant" id="enseignant" required>
            <option value="">-- Sélectionnez un enseignant --</option>
            <?php foreach ($enseignantsOptions as $enseignant): ?>
                <option value="<?php echo htmlspecialchars($enseignant['ID']); ?>">
                    <?php echo htmlspecialchars($enseignant['Nom'] . ' ' . $enseignant['Prenom']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="submit" value="Ajouter">
    </form>
</main>
</body>
</html>