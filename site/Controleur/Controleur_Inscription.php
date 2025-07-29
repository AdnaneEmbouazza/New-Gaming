<?php
require_once "Modele/classeTechnique/Authentification.php";

class ControleurInscription {
    private Authentification $auth;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->auth = new Authentification();
    }

    public function afficher(): void {
        require "Vue/vue.inscription.php";
    }

    public function inscription(): void {
        if (isset($_POST['mailU']) && isset($_POST['pseudoU']) &&
            isset($_POST['ageU']) && isset($_POST['mdpU'])) { // Vérification des champs


            try {
                $resultat = $this->auth->register( // Inscription avec la methode register
                    $_POST['mailU'],
                    $_POST['pseudoU'],
                    $_POST['mdpU'],
                    intval($_POST['ageU'])
                );

                if ($resultat) { // Si l'inscription a réussi
                    header('Location: index.php?action=connexion');
                    exit();
                }
            } catch (Exception $e) { // Si une erreur se produit
                $_SESSION['erreur'] = "Erreur lors de l'inscription";
            }

            header('Location: index.php?action=inscription');
            exit();
        }
    }
}