<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Panier</title>
    <link rel="stylesheet" href="css/panier.css">
</head>
<body>
<?php include_once __DIR__ . "/header.php"; ?>

<div class="panier-container">
    <h1>Mon Panier</h1>

    <?php // Partie du Code qui gére la validation/erreur lors de l'insertion avec des messages(voir la gestion des erreur dans le controleur) ss
    if (isset($_GET['success']) && $_GET['success'] == 1): // si succès ?>
        <div class="message success">
            Votre commande a été validée avec succès !
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="message error">
            <?php if ($_GET['error'] == 1): // si erreur au niveau de l'insertion dans commande ?>
                Une erreur est survenue lors de la création de la commande.
            <?php elseif ($_GET['error'] == 2): // si erreur au niveau de l'insertion dans contenir ?>
                Une erreur est survenue lors de l'ajout des jeux à la commande.
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if (empty($jeuxPanier)) : // si le panier est vide ?>
        <p class="panier-vide">Votre panier est vide</p>
    <?php else : ?>
        <div class="liste-jeux">
            <?php foreach ($jeuxPanier as $jeu) : // partie du code qui gere l'affichage des jeux dans le panier ?>
                <div class="jeu-panier">
                    <?php if (isset($mediaAffiches[$jeu->getIdJeu()])) : ?>
                        <img src="<?= htmlspecialchars($mediaAffiches[$jeu->getIdJeu()]->getCheminMedia()) ?>"
                             alt="<?= htmlspecialchars($jeu->getNomJeu()) ?>"
                             class="jeu-image">
                    <?php endif; ?>
                    <div class="jeu-info">
                        <h3><?= htmlspecialchars($jeu->getNomJeu()) ?></h3>
                        <p class="jeu-prix"><?= htmlspecialchars($jeu->getPrix()) ?> €</p>
                        <a href="index.php?action=monPanier&supprimer=<?= htmlspecialchars($jeu->getIdJeu()) // bouton pour la supression d'un jeu du panier ?>"
                           class="btn-supprimer">Supprimer</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="panier-total">
            <p>Total : <?= number_format($total, (2)) // Pour afficher combien de jeux dans le panier ?> €</p>
            <?php if (!empty($jeuxPanier)) : ?>
                <a href="index.php?action=monPanier&valider=1" class="btn-valider">Acheter</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <a href="index.php?action=listeJeu" class="btn-retour">← Continuer mes achats</a>
</div>
</body>
</html>
