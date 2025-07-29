<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - NewGaming</title>
    <link rel="stylesheet" href="css/auth.css">
</head>
<body>
<?php include_once __DIR__ . "/header.php"; ?>
<div class="form-container">
    <h2>Connexion</h2>
    <!-- Formulaire de connexion -->
    <form action="index.php?action=connexion" method="POST">
        <div class="form-group">
            <label for="mailU">Email</label>
            <input type="email" id="mailU" name="mailU" required>
        </div>
        <div class="form-group">
            <label for="mdpU">Mot de passe</label>
            <input type="password" id="mdpU" name="mdpU" required>
        </div>
        <button type="submit" class="btn-submit">Se connecter</button>
        <p class="form-footer">
            Pas encore de compte ? <a href="index.php?action=inscription">S'inscrire</a>
        </p>
    </form>
</div>
</body>
</html>
