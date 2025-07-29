<?php
require_once "Modele/classeDAO/JeuVideoDAO.php";
require_once "Modele/classeDAO/MediaDAO.php";
class Controleur_Panier {
    private $jeuDAO;
    private $mediaDAO;
    public function __construct() {
        $this->jeuDAO = new JeuVideoDAO();
        $this->mediaDAO = new MediaDAO();
    }

    public function afficherPanier(): void {
        $jeuxPanier = [];
        $total = 0;
        $mediaAffiches = $this->mediaDAO->getAllMediaAffiche();

        if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) { // Vérifier si le panier n'est pas vide
            foreach ($_SESSION['panier'] as $idJeu) { // Parcourir les ID des jeux dans le panier
                $jeu = $this->jeuDAO->getJeuById($idJeu); // Récupérer le jeu par son ID
                if ($jeu !== null) { // Vérifier si le jeu existe
                    $jeuxPanier[] = $jeu;
                    $total += $jeu->getPrix(); // Ajouter le prix du jeu au total
                }
            }
        }

        require_once('Vue/vue.Panier.php');
    }

    public function supprimerDuPanier($idJeu): void {
        if (isset($_SESSION['panier'])) { // Vérifier si le panier existe
            $index = array_search($idJeu, $_SESSION['panier']); // Rechercher l'index du jeu à supprimer
            if ($index !== false) { // Si le jeu est trouvé dans le panier
                unset($_SESSION['panier'][$index]); // Supprimer le jeu du panier
                $_SESSION['panier'] = array_values($_SESSION['panier']); // Réindexer le tableau
            }
        }
        header('Location: index.php?action=monPanier');
        exit();
    }

    public function validerPanier(): void {
        if (!isset($_SESSION['mailU']) || empty($_SESSION['panier'])) { // Vérifier si l'utilisateur est connecté et si le panier n'est pas vide
            header('Location: index.php?action=monPanier');
            exit();
        }

        $idCommande = uniqid('CMD_'); // Générer un ID de commande unique
        $dateCommande = date('Y-m-d'); // Date actuelle
        $mailU = $_SESSION['mailU']; // Adresse e-mail de l'utilisateur

        require_once "Modele/classeDAO/CommandeDAO.php";
        require_once "Modele/classeDAO/ContenirDAO.php";

        $commandeDAO = new CommandeDAO();
        $contenirDAO = new ContenirDAO();

        // Création et insertion de la commande
        if ($commandeDAO->insertCommande($idCommande, $dateCommande, $mailU)) {
            if ($contenirDAO->insererJeuxCommande($idCommande, $_SESSION['panier'])) {
                // Mettre à jour les jeux de l'utilisateur dans la collection de jeux de l'utilisateur
//                require_once "Modele/classeDAO/UtilisateurDAO.php";
//                $utilisateurDAO = new UtilisateurDAO();
//                $utilisateurDAO->updateJeuxUtilisateur($mailU);

                $_SESSION['panier'] = []; // Vider le panier après la validation
                header('Location: index.php?action=monPanier&success=1');
            } else {
                header('Location: index.php?action=monPanier&error=2');
            }
        } else {
            header('Location: index.php?action=monPanier&error=1'); // Erreur insertion Commande
        }
        exit();
    }
}