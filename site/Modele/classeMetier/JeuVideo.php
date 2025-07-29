<?php

class JeuVideo{
    private string $IdJeu ;
    private string $NomJeu ;
    private string $DateParution ;
    private string $Developpeur ;
    private string $Editeur ;
    private string $DescriptionJeu ;
    private float $Prix ;
    private int $RestrictionAge ;
    private array $MesMedias ;
    private array $MesTypes ;

    public function __construct($id , $nom , $date , $dev , $editeur , $description , $prix , $restrictionAge ){
        $this -> IdJeu = $id ;
        $this -> NomJeu = $nom ;
        $this -> DateParution = $date ;
        $this -> Developpeur = $dev ;
        $this -> Editeur = $editeur ;
        $this -> DescriptionJeu = $description ;
        $this -> Prix = $prix ;
        $this -> RestrictionAge = $restrictionAge ;
        $this -> MesMedias = [];
        $this -> MesTypes = [];

    }

    public function getIdJeu(){
        return $this -> IdJeu;
    }

    public function getNomJeu(){
        return $this -> NomJeu;
    }

    public function getDateParution(){
        return $this -> DateParution;
    }

    public function getDeveloppeur(){
        return $this -> Developpeur;
    }

    public function getEditeur(){
        return $this -> Editeur;
    }

    public function getDescriptionJeu(){
        return $this -> DescriptionJeu;
    }

    public function getPrix(){
        return $this -> Prix;
    }

    public function getRestrictionAge(){
        return $this -> RestrictionAge;
    }

    public function getMesMedias(){
        return $this -> MesMedias;
    }

    public function getMesTypes(){
        return $this -> MesTypes;
    }

    public function setIdJeu($id){
        $this -> IdJeu = $id;
    }

    public function setNomJeu($nom){
        $this -> NomJeu = $nom;
    }

    public function setDateParution($date){
        $this -> DateParution = $date;
    }

    public function setDeveloppeur($dev){
        $this -> Developpeur = $dev;
    }

    public function setEditeur($editeur){
        $this -> Editeur = $editeur;
    }

    public function setDescriptionJeu($description){
        $this -> DescriptionJeu = $description;
    }

    public function setPrix($prix){
        $this -> Prix = $prix;
    }

    public function setRestrictionAge($restrictionAge){
        $this -> RestrictionAge = $restrictionAge;
    }

    public function setMesMedias($mesMedias){
        $this -> MesMedias = $mesMedias;
    }

    public function setMesTypes($mesTypes){
        $this -> MesTypes = $mesTypes;
    }

    public function ajouterMedia(array $Medias /*tableau d'objets media*/){
        foreach ($Medias as $media ){
            if ($media -> getIdJeu() == $this ->getIdJeu()){
                $this -> MesMedias[] = $media ;
            }
        }
    }

    public function ajouterType(array $Determiner /*tableau d'objets determiner de la table determiner (idtypeJeu + idJeu*/){
        foreach ($Determiner as $Deter ){
            if ($Deter -> getIdJeu() == $this ->getIdJeu()){
                $this -> MesTypes[] = $Deter ;
            }
        }
    }
}