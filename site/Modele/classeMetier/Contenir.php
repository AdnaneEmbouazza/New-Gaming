<?php

class contenir {
    private string $IdJeu ;

    private string $IdCommande ;


    public function __construct( $IdJeu , $IdCommande){
        $this -> IdJeu = $IdJeu ;
        $this -> IdCommande = $IdCommande ;
    }
    public function getIdJeu(): string {
        return $this -> IdJeu ;
    }

    public function setIdJeu($IdJeu): void {
        $this -> IdJeu = $IdJeu ;
    }

    public function getIdCommande(): string {
        return $this -> IdCommande ;
    }

    public function setIdCommande($IdCommande): void {
        $this -> IdCommande = $IdCommande ;
    }

    public function __toString(): string {
        return "Contenir : " . $this->IdJeu . ", ID Commande : " . $this->IdCommande;
    }

}