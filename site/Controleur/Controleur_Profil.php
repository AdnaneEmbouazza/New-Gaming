<?php
require_once "Modele/classeDAO/UtilisateurDAO.php";

class Controleur_Profil {
    private UtilisateurDAO $utilisateurDAO;

    public function __construct() {
        $this->utilisateurDAO = new UtilisateurDAO();
    }

    public function afficherProfil(): void {
        if (!isset($_SESSION['utilisateur'])) {
            header('Location: index.php?action=connexion');
            exit();
        }

        $utilisateur = unserialize($_SESSION['utilisateur']);

        require_once('Vue/vue.profil.php');
    }

    public function modifierInfos(): void {
        if (!isset($_SESSION['mailU'])) {
            header('Location: index.php?action=connexion');
            exit();
        }

        $mailU = $_SESSION['mailU'];
        $nouveauPseudo = !empty($_POST['pseudo']) ? trim($_POST['pseudo']) : null; // Récupère le noueau pseudo
        $nouveauMdp = !empty($_POST['motdepasse']) ? trim($_POST['motdepasse']) : null; // Récupère le nouveau mot de passe

        // Vérifie si au moins un champ est rempli
        if ($nouveauPseudo === null && $nouveauMdp === null) {
            $_SESSION['erreur'] = "Aucune modification demandée";
            header('Location: index.php?action=profil');
            exit();
        }

        $resultat = $this->utilisateurDAO->updateUserInfo($mailU, $nouveauPseudo, $nouveauMdp); // Appel à la méthode updateUserInfo pour mettre à jour les informations de l'utilisateur

        if ($resultat) {
            $_SESSION['message'] = "Informations mises à jour avec succès"; // Message de succès
        } else {
            $_SESSION['erreur'] = "Erreur lors de la mise à jour"; // Message d'erreur
        }

        header('Location: index.php?action=profil');
        exit();
    }

    public function supprimerCommande()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idCommande'])) {
            $idCommande = $_POST['idCommande'];

            require_once("Modele/classeDAO/CommandeDAO.php");
            $commandeDAO = new CommandeDAO();

            if ($commandeDAO->deleteCommande($idCommande)) {
                // Recharger l'utilisateur avec ses nouvelles commandes
                if (isset($_SESSION['utilisateur'])) {
                    if (is_string($_SESSION['utilisateur'])) {
                        $_SESSION['utilisateur'] = unserialize($_SESSION['utilisateur']);
                    }

                    $mail = $_SESSION['utilisateur']->getMailU();

                    require_once("Modele/classeDAO/UtilisateurDAO.php");
                    $utilisateurDAO = new UtilisateurDAO();
                    $_SESSION['utilisateur'] = serialize($utilisateurDAO->getUserByMail($mail));
                }

                $_SESSION['message'] = "Commande annulée avec succès.";
            } else {
                $_SESSION['erreur'] = "Erreur lors de l'annulation de la commande.";
            }
        }

        header("Location: index.php?action=profil");
        exit();
    }



}