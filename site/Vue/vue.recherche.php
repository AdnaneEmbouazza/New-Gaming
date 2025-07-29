<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $titre ?></title>
    <link rel="stylesheet" href="css/recherche.css">
</head>
<body>
<?php include_once __DIR__ . "/header.php"; ?>

<div class="resultats-recherche">
    <h1 class="resultats-titre">Résultats pour "<?= htmlspecialchars($terme) // affiche le terme de la recherche?>"</h1>

    <div class="jeux-grid">
        <?php foreach ($resultats as $jeu): // parcourt les jeux corrrespondant a la recherche ?>
            <div class="jeu-card">
                <h3 class="jeu-title"><?= htmlspecialchars($jeu->getNomJeu()) ?></h3>
                <p class="jeu-info">Développeur : <?= htmlspecialchars($jeu->getDeveloppeur()) ?></p>
                <p class="jeu-prix"><?= number_format($jeu->getPrix(), 2) ?> €</p>
                <a href="index.php?action=detailsJeu&id=<?= $jeu->getIdJeu() ?>" class="btn-details">Voir le jeu</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>