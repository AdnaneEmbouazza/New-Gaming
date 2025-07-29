<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le jeu</title>
    <link rel="stylesheet" href="css/modifierJeu.css">
</head>
<body>
<?php include_once __DIR__ . "/header.php"; ?>

<h2>Modifier le jeu : <?= htmlspecialchars($jeu->getNomJeu()) ?></h2>

<form action="index.php?action=admin&operation=modifierJeu&idjeu=<?= urlencode($jeu->getIdJeu()) ?>" method="POST">
    <label for="nomJeu">Nom du jeu :</label>
    <input type="text" name="nomJeu" id="nomJeu" value="<?= htmlspecialchars($jeu->getNomJeu()) ?>" required><br>

    <label for="dateParution">Date de parution :</label>
    <input type="date" name="dateParution" id="dateParution" value="<?= htmlspecialchars($jeu->getDateParution()) ?>" required><br>

    <label for="developpeur">Développeur :</label>
    <input type="text" name="developpeur" id="developpeur" value="<?= htmlspecialchars($jeu->getDeveloppeur()) ?>" required><br>

    <label for="editeur">Éditeur :</label>
    <input type="text" name="editeur" id="editeur" value="<?= htmlspecialchars($jeu->getEditeur()) ?>" required><br>

    <label for="description">Description :</label>
    <textarea name="description" id="description" required><?= htmlspecialchars($jeu->getDescriptionJeu()) ?></textarea><br>

    <label for="prix">Prix (€) :</label>
    <input type="number" step="0.01" name="prix" id="prix" value="<?= htmlspecialchars($jeu->getPrix()) ?>" required><br>

    <label for="restrictionAge">Restriction d'âge :</label>
    <input type="number" name="restrictionAge" id="restrictionAge" value="<?= htmlspecialchars($jeu->getRestrictionAge()) ?>" required><br>

    <button type="submit">Enregistrer les modifications</button>
    <a href="index.php?action=admin"><button type="button">Annuler</button></a>
</form>


</body>
</html>
