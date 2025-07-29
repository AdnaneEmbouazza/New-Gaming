<?php
require_once "Modele/classeTechnique/Authentification.php";

class ControleurDeconnexion {
    private Authentification $auth;

    public function __construct() {
        $this->auth = new Authentification();
    }

    public function deconnexion(): void {
        $this->auth->logout(); // Déconnexion de l'utilisateur
        header('Location: index.php?action=connexion');
        exit();
    }
}