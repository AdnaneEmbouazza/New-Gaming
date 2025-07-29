<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Jeu Vidéo</title>
    <link rel="stylesheet" href="css/listeJeu.css">
</head>
<body>
<?php include_once __DIR__ . "/header.php"; ?>
<div class="container">
<?php
foreach($jeux as $jeu) { // Affichage de chaque jeu
    if (isset($mediaAffiches[$jeu->getIdJeu()])) { // vérifie que le jeu a une affiche pour l'afficher?>
        <div class="jeu-card">
            <img src="<?php echo htmlspecialchars($mediaAffiches[$jeu->getIdJeu()]->getCheminMedia()); ?>" alt="Image_affiche">
            <h2 class="jeu-title"><?php echo htmlspecialchars($jeu->getNomJeu()); ?></h2>
            <p class="jeu-info">Date de parution : <?php echo htmlspecialchars($jeu->getDateParution()); ?></p>
            <p class="jeu-info">Âge requis : <span class="restriction-age"><?php echo htmlspecialchars($jeu->getRestrictionAge()); ?>+</span></p>
            <a href="index.php?action=detailsJeu&id=<?php echo htmlspecialchars($jeu->getIdJeu()); ?>" class="btn-savoir-plus">En savoir plus</a>
        </div>
        <?php
    }
} ?>
</div>
</body>
</html>