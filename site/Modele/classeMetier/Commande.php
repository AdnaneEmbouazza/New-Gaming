<?php

class Commande {
    private string $IdCommande ;
    private string $DateCommande;
    private Utilisateur $unUtilisateur;
    private string $mailU;
    private array $lesJeux ;

    public function __construct($id , $date , $user , $mailU){
        $this -> IdCommande = $id ;
        $this -> DateCommande = $date ;
        $this -> unUtilisateur = $user ;
        $this -> mailU = $mailU ;
        $this -> lesJeux = [];
    }

    public function getIdCommande(): string {
        return $this -> IdCommande ;
    }

    public function setIdCommande($id): void {
        $this -> IdCommande = $id ;
    }

    public function getDateCommande(): string {
        return $this -> DateCommande ;
    }

    public function setDateCommande($date): void {
        $this -> DateCommande = $date ;
    }

    public function getUtilisateur(): Utilisateur {
        return $this -> unUtilisateur ;
    }

    public function setUtilisateur(Utilisateur $user): void {
        $this -> unUtilisateur = $user ;
    }

    public function getJeux(): array {
        return $this -> lesJeux ;
    }

    public function setJeux($jeux): void {
        $this -> lesJeux = $jeux ;
    }

    public function getMailU(): string {
        return $this -> mailU ;
    }

    public function setMailU($mailU): void {
        $this -> mailU = $mailU ;
    }

    public function __toString(): string {
        return "Commande : " . $this->IdCommande . ", Date : " . $this->DateCommande . ", Utilisateur : " . $this->unUtilisateur->getNom() . ", Mail : " . $this->mailU;
    }

    public function addJeu($jeu): void {
        $this->lesJeux[] = $jeu;
    }

    public function removeJeu($jeu): void {
        if (($key = array_search($jeu, $this->lesJeux)) !== false) {
            unset($this->lesJeux[$key]);
        }
    }
}