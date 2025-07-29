<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panneau d'administration</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="admin-container">
    <h1>Panneau d'administration</h1>

    <!-- Section Gestion des Jeux -->
    <section class="admin-section">
        <h2>Gestion des Jeux</h2>
        <button onclick="toggleForm('ajoutJeu')">Ajouter un jeu</button> <!-- Bouton pour ajouter un jeu -->
        <!-- Les differents champs du formulaire d'ajout -->
        <form id="ajoutJeu" class="admin-form" action="index.php?action=admin&operation=ajouterJeu" method="POST" style="display: none;">
            <input type="text" name="nomJeu" placeholder="Nom du jeu" required>
            <input type="date" name="dateParution" required>
            <input type="text" name="developpeur" placeholder="Développeur" required>
            <input type="text" name="editeur" placeholder="Éditeur" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <input type="number" name="prix" step="0.01" placeholder="Prix" required>
            <input type="number" name="restrictionAge" placeholder="Âge minimum" required>
            <button type="submit">Ajouter</button>
        </form>

        <table class="jeux-liste">
            <tr>
                <th>Nom</th>
                <th>Prix</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($jeux as $jeu): // parcours tous les jeux ?>
                <tr>
                    <td><?= htmlspecialchars($jeu->getNomJeu()) ?></td>
                    <td><?= number_format($jeu->getPrix(), 2) ?> €</td>
                    <td>
                        <a href="index.php?action=admin&operation=modifierJeu&idjeu=<?= urlencode($jeu->getIdJeu()) ?>">Modifier</a>
                        <a href="index.php?action=admin&operation=supprimerJeu&idjeu=<?= urlencode($jeu->getIdJeu()) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce jeu ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </section>

    <!-- Section Upload Médias -->
    <section class="admin-section">
        <h2>Gestion des Médias</h2>
        <form action="index.php?action=admin&operation=uploadMedia" method="POST" enctype="multipart/form-data">
            <label for="jeuId">Jeu :</label>
            <select name="jeuId" required>
                <?php foreach ($jeux as $jeu): ?>
                    <option value="<?= $jeu->getIdJeu() ?>"><?= htmlspecialchars($jeu->getNomJeu()) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="media">Image (jpg seulement) :</label>
            <input type="file" name="media" accept=".jpg" required>

            <button type="submit">Télécharger</button>
        </form>
    </section>
</div>

<script>
    function toggleForm(formId) {
        const form = document.getElementById(formId);
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

    function modifierJeu(id) {
        window.location.href = `index.php?action=modifierJeu&id=${id}`;
    }

    function supprimerJeu(id) {
        if (confirm('Êtes-vous sûr de vouloir supprimer ce jeu ?')) {
            window.location.href = `index.php?action=admin&operation=supprimerJeu&id=${id}`;
        }
    }
</script>
</body>
</html>
