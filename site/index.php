<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

//include_once __DIR__ ."/Vue/header.php";

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'detailsJeu': // cas pour afficher les détails d'un jeu
            if (isset($_GET['id'])) {
                include "Controleur/Controleur_DetailsJeu.php";
                $controleurDetails = new ControleurDetailsJeu();
                $controleurDetails->afficherDetails($_GET['id']);
            }
            break;

        case 'ajouterCritique': // cas pour ajouter une critique
            if (isset($_SESSION['mailU'])) {
                include "Controleur/Controleur_DetailsJeu.php";
                $controleur = new ControleurDetailsJeu();
                $controleur->ajouterCritique();
            } else {
                header('Location: index.php?action=connexion');
                exit();
            }
            break;

        case 'supprimerCritique': // cas pour supprimer une critique
            if (isset($_SESSION['mailU'])) {
                include "Controleur/Controleur_DetailsJeu.php";
                $controleur = new ControleurDetailsJeu();
                $controleur->supprimerCritique();
            } else {
                header('Location: index.php?action=connexion');
            }
            break;


        case 'modifierCritique': // cas pour modifier une critique
            if (isset($_SESSION['mailU'])) {
                include "Controleur/Controleur_DetailsJeu.php";
                $controleur = new ControleurDetailsJeu();
                $controleur->modifierCritique();
            } else {
                header('Location: index.php?action=connexion');
            }
            break;


        case 'listeJeu':  // cas pour gérer le retour à la liste de jeu
            include "Controleur/Controleur_ListeJeu.php";
            $controleurListe = new ControleurListeJeu();
            $controleurListe->afficherListe();
            break;


        case 'connexion': // cas pour gérer la connexion
            include "Controleur/Controleur_Connexion.php";
            $controleurConnexion = new ControleurConnexion();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Vérifie si le formulaire a été soumis
                $controleurConnexion->connexion();
            } else {
                $controleurConnexion->afficher();
            }
            break;


        case 'inscription':// cas pour gérer l'inscription
            // Vérifie si l'utilisateur est déjà connecté
            if (isset($_SESSION['mailU'])) {
                header('Location: index.php?action=listeJeu');
                exit();
            }
            include "Controleur/Controleur_Inscription.php";
            $controleurInscription = new ControleurInscription();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controleurInscription->inscription();
            }else {
                $controleurInscription->afficher();
            }
            break;


        case 'deconnexion': // cas pour gérer la déconnexion
            include "Controleur/Controleur_Deconnexion.php";
            $controleurDeconnexion = new ControleurDeconnexion();
            $controleurDeconnexion->deconnexion();
            break;


        case 'monPanier': // cas pour gérer le panier
            // Vérifie si l'utilisateur est connecté
            if (!isset($_SESSION['mailU'])) {
                header('Location: index.php?action=connexion');
                exit();
            }
            require_once("Controleur/Controleur_Panier.php");
            $controleurPanier = new Controleur_Panier();

            if (isset($_GET['supprimer'])) {
                $controleurPanier->supprimerDuPanier($_GET['supprimer']);} // supprime le jeu correspondant du panier (uniquement sur appui du bouton)

            // condition pour la validation du panier
            elseif (isset($_GET['valider'])) {
                $controleurPanier->validerPanier();
            }

            // Gestion de l'ajout au panier si un ID est fourni
            elseif (isset($_GET['id'])) {
                require_once("Controleur/Controleur_DetailsJeu.php");
                $controleurDetails = new ControleurDetailsJeu();
                $controleurDetails->ajouterAuPanier($_GET['id']); // ajoute le jeu correspondant au panier
                // Pas besoin de break car ajouterAuPanier() redirige déjà au bon endroit
            }
            // Affichage du panier
            require_once("Controleur/Controleur_Panier.php");
            $controleurPanier = new Controleur_Panier();
            $controleurPanier->afficherPanier();
            break;

        case 'profil': // cas pour afficher le profil de l'utilisateur
            // Vérifie si l'utilisateur est connecté
            if (!isset($_SESSION['mailU'])) {
                header('Location: index.php?action=connexion');
                exit();
            }
            require_once("Controleur/Controleur_Profil.php");
            $controleurProfil = new Controleur_Profil();
            $controleurProfil->afficherProfil();
            break;


        case 'modifierInfos': // cas pour modifier les informations du profil
            require_once("Controleur/Controleur_Profil.php");
            $controleur = new Controleur_Profil();
            $controleur->modifierInfos();
            break;


        case 'supprimerCommande': // cas pour supprimer une commande
            require_once("Controleur/Controleur_Profil.php");
            $controleur = new Controleur_Profil();
            $controleur->supprimerCommande(); // Appel à la méthode pour supprimer une commande
            break;

        case 'rechercher':
            require_once('Controleur/Controleur_Recherche.php');
            $controleur = new Controleur_Recherche();
            $controleur->rechercher();
            break;


        case 'admin': // cas pour gérer le panneau d'administration
            require_once('Controleur/Controleur_Admin.php');
            $controleur = new Controleur_Admin();

            $operation = $_GET['operation'] ?? null;
            switch ($operation) {
                case 'ajouterJeu': // cas pour ajouter un jeu
                    $controleur->ajouterJeu();
                    break;
                case 'supprimerJeu': // cas pour supprimer un jeu
                    $controleur->supprimerJeu(); // Appel à la méthode pour supprimer un jeu
                    break;
                case 'modifierJeu': // cas pour modifier un jeu
                    $controleur->modifierJeu(); // Appel à la méthode pour modifier un jeu
                    break;
                case 'uploadMedia': //cas pour gérer l'upload de médias
                    $controleur->uploadMedia(); // Appel à la méthode uploadMedia() du contrôleur
                    break;
                default:
                    $controleur->afficherPanneauAdmin(); // Par défaut, on affiche le panneau d'administration
                    break;
            }
            break;




        default:  // Par défaut, on affiche aussi la liste des jeux
            include "Controleur/Controleur_ListeJeu.php";
            $controleurListe = new ControleurListeJeu();
            $controleurListe->afficherListe();
    }
} else {
        // Ce cas est nécessaire pour l'affichage initial
        include "Controleur/Controleur_ListeJeu.php";
        $controleurListe = new ControleurListeJeu();
        $controleurListe->afficherListe();
}
