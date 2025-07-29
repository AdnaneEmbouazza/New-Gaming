<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - NewGaming</title>
    <link rel="stylesheet" href="css/auth.css">
</head>
<body>
<?php include_once __DIR__ . "/header.php"; ?>
<div class="form-container">
    <!-- Formulaire d'inscription -->
    <h2>Inscription</h2>
    <form action="index.php?action=inscription" method="POST">
        <div class="form-group">
            <label for="mailU">Email</label>
            <input type="email" id="mailU" name="mailU" required>
        </div>
        <div class="form-group">
            <label for="pseudoU">Pseudo</label>
            <input type="text" id="pseudoU" name="pseudoU" required>
        </div>
        <div class="form-group">
            <label for="mdpU">Mot de passe</label>
            <input type="password" id="mdpU" name="mdpU" required>
        </div>
        <div class="form-group">
            <label for="ageU">Âge</label>
            <input type="number" id="ageU" name="ageU" min="13" max="100" required>
        </div>
        <button type="submit" class="btn-submit">S'inscrire</button>
        <p class="form-footer">
            Déjà inscrit ? <a href="index.php?action=connexion">Se connecter</a>
        </p>
    </form>
</div>
</body>
</html>