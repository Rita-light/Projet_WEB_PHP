<?php
require_once(__DIR__ . '/../FichierPHP/verifierConnexion.php');
require_once(__DIR__ . '/../FichierPHP/gestGroupeProfesseur.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion Groupes-Professeurs</title>
  <link rel="stylesheet" href="../FichierCSS/style2.css">
</head>
<body>
  <header>
    <h1>Gérer les Associations Groupes-Professeurs</h1>
  </header>
  <nav>
    <a href="gestionCours.php">Retour</a>
  </nav>

  <main>
    <h2>Liste des Associations</h2>
    <table border="1">
      <thead>
        <tr>
          <th>Nom du Groupe</th>
          <th>Nom de l’Enseignant</th>
        </tr>
      </thead>
      <tbody>
        <?php afficherAssociations($dbConnection, $departementId); ?>
      </tbody>
    </table>

    <h2>Ajouter une Association</h2>
    <form method="POST" action="../FichierPHP/gestGroupeProfesseur.php">
      <label for="groupe">Groupe :</label>
      <select name="groupe" id="groupe" required>
        <option value="">-- Sélectionnez un Groupe --</option>
        <?php afficherGroupes($dbConnection, $departementId); ?>
      </select>
      
      <label for="enseignant">Enseignant :</label>
      <select name="enseignant" id="enseignant" required>
        <option value="">-- Sélectionnez un Professeur --</option>
        
      </select>

      <input type="submit" value="Ajouter">
    </form>

  </main>

  <script>
    document.getElementById('groupe').addEventListener('change', function () {
        const groupeId = this.value;
        const professeurSelect = document.getElementById('enseignant');
        professeurSelect.innerHTML = '<option value="">-- Chargement... --</option>';

        if (groupeId !== '') {
            fetch('../FichierPHP/getProfesseurByCours.php?idGroupe=' + encodeURIComponent(groupeId))
                .then(response => response.json())
                .then(data => {
                    professeurSelect.innerHTML = '<option value="">-- Sélectionnez un Professeur --</option>';
                    data.forEach(professeur => {
                        const option = document.createElement('option');
                        option.value = professeur.ID;
                        option.textContent = professeur.Nom + ' ' + professeur.Prenom;
                        professeurSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    professeurSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                    console.error('Erreur:', error);
                });
        } else {
            professeurSelect.innerHTML = '<option value="">-- Sélectionnez un Professeur --</option>';
    }
});
</script>

</body>
</html>