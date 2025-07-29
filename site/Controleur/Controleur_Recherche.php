<?php
require_once "Modele/classeDAO/JeuVideoDAO.php";

class Controleur_Recherche {
    private JeuVideoDAO $jeuVideoDAO;

    public function __construct() {
        $this->jeuVideoDAO = new JeuVideoDAO();
    }

    public function rechercher(): void {
        $terme = trim(htmlspecialchars(
            filter_input(INPUT_GET, 'q') ?? '', // Récupérer le terme de recherche
            ENT_QUOTES, // Convertit les caractères spéciaux
            'UTF-8' // Utiliser l'encodage UTF-8
        ));

        if (!empty($terme)) {
            $resultats = $this->jeuVideoDAO->rechercherJeux($terme);
            // Définir les variables pour la vue
            $titre = "Résultats de recherche";
            // Rendre les variables disponibles pour la vue
            require_once('Vue/vue.recherche.php');
        } else {
            header('Location: index.php');
        }
    }
}