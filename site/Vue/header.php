<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NewGaming</title>
    <link rel="stylesheet" href="css/header.css">
</head>

<body>
<header>
    <div class="header-overlay"></div>
    <div class="header-container">
        <div class="search-container">
            <form action="index.php" method="GET" class="search-form">
                <input type="hidden" name="action" value="rechercher">
                <input type="search" name="q" placeholder="Rechercher un jeu..." class="search-input" required>
                <button type="submit" class="search-button">🔍</button>
            </form>
        </div>
        <div class="auth-buttons">
            <?php if (isset($_SESSION['mailU'])) : ?>
                <button class="btn-profil"><a href="index.php?action=profil">Mon Profil</a></button>
                <button class="btn-panier">
                    <a href="index.php?action=monPanier">
                        Mon Panier
                        <?php if (isset($_SESSION['panier']) && count($_SESSION['panier']) > 0) : // vérifie que le panier existe en session et contient au moins 1 article ?>
                            <span class="panier-count"><?= count($_SESSION['panier']) ?></span>
                        <?php endif; ?>
                    </a>
                </button>
                <button class="btn-deconnexion"><a href="index.php?action=deconnexion">Déconnexion</a></button>
            <?php else : ?>
                <button class="btn-connexion"><a href="index.php?action=connexion">Connexion</a></button>
                <button class="btn-inscription"><a href="index.php?action=inscription">S'inscrire</a></button>
            <?php endif; ?>
        </div>
    </div>
</header>