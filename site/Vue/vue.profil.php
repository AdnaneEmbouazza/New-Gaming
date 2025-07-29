<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Jeu Vidéo</title>
    <link rel="stylesheet" href="css/profil.css">
</head>
<body>
<?php include_once __DIR__ . "/header.php"; ?>
<h1>Mon Profil</h1>

<?php if (isset($_SESSION['erreur'])): ?>
    <div class="alert alert-error">
        <?php
        echo $_SESSION['erreur'];
        unset($_SESSION['erreur']);
        ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-success">
        <?php
        echo $_SESSION['message'];
        unset($_SESSION['message']);
        ?>
    </div>
<?php endif; ?>

<div class="profile-container">
    <div class="info-utilisateur">
        <h2>Mes Informations</h2>
        <p><strong>Mail :</strong> <?= htmlspecialchars($utilisateur->getMailU()) ?></p>
        <p><strong>Pseudo :</strong> <?= htmlspecialchars($utilisateur->getPseudoU()) ?></p>
        <p><strong>Age :</strong> <?= $utilisateur->getAgeU() ?> ans</p>

        <div class="modifier-profil">
            <h3>Modifier mes informations</h3>
            <form action="index.php?action=modifierInfos" method="POST" class="form-profil">
                <div class="form-group">
                    <label for="pseudo">Nouveau pseudo (facultatif) :</label>
                    <input type="text" id="pseudo" name="pseudo" minlength="3">
                </div>
                <div class="form-group">
                    <label for="motdepasse">Nouveau mot de passe (facultatif) :</label>
                    <input type="password" id="motdepasse" name="motdepasse" minlength="8">
                </div>
                <button type="submit" class="btn-action">Modifier</button>
            </form>
        </div>
        <?php if ($utilisateur->isAdmin()): // si l'utilisateur est admin alors, il a accès au panneau d'administration ?>
            <div class="admin-section">
                <a href="index.php?action=admin" class="btn btn-admin">
                    Panneau d'administration
                </a>
            </div>
        <?php endif; ?>
    </div>

    <div class="historique-commandes">
        <h2>Historique des Commandes</h2>
        <?php if (!empty($utilisateur->getMesCommandes())): ?>
            <?php foreach ($utilisateur->getMesCommandes() as $commande):?>
                <div class="commande">
                    <h3>Commande #<?= htmlspecialchars($commande->getIdCommande()) ?></h3>
                    <p>Date : <?= htmlspecialchars($commande->getDateCommande()) ?></p>
                    <div class="jeux-commande">
                        <h4>Jeux achetés :</h4>
                        <ul>
                            <?php foreach ($commande->getJeux() as $jeu): ?>
                                <li><?= htmlspecialchars($jeu->getNomJeu()) ?> - <?= number_format($jeu->getPrix(), 2) ?> €</li>
                            <?php endforeach; ?>

                        </ul>
                    </div>
                    <!-- BOUTON DE REMBOURSEMENT -->
                    <form action="index.php?action=supprimerCommande" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette commande ?');">
                        <input type="hidden" name="idCommande" value="<?= htmlspecialchars($commande->getIdCommande()) ?>">
                        <button type="submit" class="btn btn-danger">Voulez-vous être remboursé ?</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune commande effectuée.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>