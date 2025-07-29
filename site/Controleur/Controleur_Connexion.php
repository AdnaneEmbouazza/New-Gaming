<?php
require_once "Modele/classeTechnique/Authentification.php";

class ControleurConnexion {
    private Authentification $auth;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->auth = new Authentification();
    }

    public function connexion(): void {
        if (isset($_POST['mailU']) && isset($_POST['mdpU'])) { // Vérification des champs
            $resultat = $this->auth->login($_POST['mailU'], $_POST['mdpU']); // Authentification via la methode login

            if ($resultat) { // Authentification réussie
                header('Location: index.php?action=listeJeu');
                exit();
            } else { // Authentification échouée
                header('Location: index.php?action=connexion');
                exit();
            }
        }
    }

    public function afficher(): void {
        require "Vue/vue.connexion.php";
    }
}