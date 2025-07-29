<?php

require_once __DIR__ . "/../Modele/classeDAO/JeuVideoDAO.php";
require_once __DIR__ . "/../Modele/classeDAO/MediaDAO.php";
class ControleurListeJeu {
    private JeuVideoDao $jeuDAO;
    private MediaDAO $mediaDAO;

    public function __construct() {
        $this->jeuDAO = new JeuVideoDao();
        $this->mediaDAO = new MediaDAO();
    }

    public function afficherListe(): void { // void car pas de retour
        $jeux = $this->jeuDAO->getAllJeu(); // récupération de tous les jeux
        $mediaAffiches = $this->mediaDAO->getAllMediaAffiche(); // récupération de tous les médias affiches
        include "Vue/vue.listeJeu.php";
    }
}