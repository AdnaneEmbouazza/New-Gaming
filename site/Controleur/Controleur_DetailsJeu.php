<?php

require_once "Modele/classeDAO/JeuVideoDAO.php";
require_once "Modele/classeDAO/MediaDAO.php";
require_once "Modele/classeDAO/DeterminerDAO.php";
require_once "Modele/classeDAO/CritiquerDAO.php";
class ControleurDetailsJeu {
    private JeuVideoDao $jeuDAO;
    private MediaDAO $mediaDAO;
    private DeterminerDAO $determiner;

    private CritiquerDAO $critiquerDAO;

    public function __construct() {
        $this->jeuDAO = new JeuVideoDao();
        $this->mediaDAO = new MediaDAO();
        $this->determiner = new DeterminerDAO();
        $this->critiquerDAO = new CritiquerDAO();
    }

    public function afficherDetails(string $id): void {
        $jeu = $this->jeuDAO->getJeuById($id);
        if ($jeu !== null) {
            $mediaImages = $this->mediaDAO->getAllMediaSaufAffiche();
            $mediaAffiches = $this->mediaDAO->getAllMediaAffiche();
            $typeJeu = $this->determiner->getDeterminerbyIdJeu($id);
            $critiques = $this->critiquerDAO->getCritiqueByIdJeu($id);
            $jeu->ajouterType($typeJeu); /* Ajoute les types de jeux recoltés à l'objet jeu */
            $jeu->ajouterMedia($mediaImages); /* Ajoute les images recoltés à l'objet jeu */
            $jeu->ajouterMedia(array_values($mediaAffiches)); /* Ajoute les affiches recoltés à l'objet jeu */
            include "Vue/vue.DetailsJeu.php";
        } else {
            // Redirection ou gestion d'erreur si le jeu n'existe pas
            header('Location: index.php?action=listeJeu');
            exit();
        }
    }

    public function ajouterCritique(): void {
        if (!isset($_POST['idJeu'], $_POST['note'], $_POST['commentaire'])) {
            header('Location: index.php?action=listeJeu');
            exit();
        }

        $idJeu = $_POST['idJeu'];
        $note = (int)$_POST['note']; // S'assurer que la note est un entier
        $commentaire = $_POST['commentaire'];
        $mailU = $_SESSION['mailU'];

        $critiquerDAO = new CritiquerDAO();
        $resultat = $critiquerDAO->addCritique($mailU, $idJeu, $note, $commentaire);

        if ($resultat) {
            $_SESSION['message'] = "Votre avis a été ajouté avec succès."; // si insertion réussie
        } else {
            $_SESSION['erreur'] = "Erreur lors de l'ajout de votre avis."; // si insertion échouée
        }

        header('Location: index.php?action=detailsJeu&id=' . $idJeu);
        exit();
    }

    public function ajouterAuPanier(string $idJeu): void {
        if (!isset($_SESSION['mailU'])) {
            header('Location: index.php?action=connexion');
            exit();
        }

        $jeu = $this->jeuDAO->getJeuById($idJeu);
        if ($jeu !== null) { // Vérifie si le jeu existe
            if (!isset($_SESSION['panier'])) {
                $_SESSION['panier'] = [];
            }

            // Évite les doublons
            if (!in_array($idJeu, $_SESSION['panier'])) {
                $_SESSION['panier'][] = $idJeu;
            }
        }

        header('Location: index.php?action=monPanier');
        exit();
    }

    public function supprimerCritique(): void {
        if (!isset($_POST['idJeu'])) {
            header('Location: index.php?action=listeJeu');
            exit();
        }

        $idJeu = $_POST['idJeu'];
        $mailU = $_SESSION['mailU'];

        $resultat = $this->critiquerDAO->deleteCritique($mailU, $idJeu); // Suppression de la critique

        if ($resultat) { // Si la suppression a réussi
            $_SESSION['message'] = "Votre avis a été supprimé avec succès.";
        } else { // Si la suppression a échoué
            $_SESSION['erreur'] = "Erreur lors de la suppression de votre avis.";
        }

        header('Location: index.php?action=detailsJeu&id=' . $idJeu);
        exit();
    }

    public function modifierCritique(): void {
        if (!isset($_POST['idJeu'], $_POST['note'], $_POST['commentaire'])) { // Vérifie si les données sont présentes
            header('Location: index.php?action=listeJeu');
            exit();
        }

        $idJeu = $_POST['idJeu'];
        $note = (int)$_POST['note']; // S'assurer que la note est un entier
        $commentaire = $_POST['commentaire'];
        $mailU = $_SESSION['mailU'];

        $resultat = $this->critiquerDAO->updateCritique($mailU, $idJeu, $note, $commentaire); // Mise à jour de la critique

        if ($resultat) { // Si la mise à jour a réussi
            $_SESSION['message'] = "Votre avis a été modifié avec succès.";
        } else { // Si la mise à jour a échoué
            $_SESSION['erreur'] = "Erreur lors de la modification de votre avis.";
        }

        header('Location: index.php?action=detailsJeu&id=' . $idJeu);
        exit();
    }
}