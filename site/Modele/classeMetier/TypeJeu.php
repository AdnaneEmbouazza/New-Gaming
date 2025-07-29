<?php
class typeJeu{
    private string $IdTypeJeu ;
    private string $NomTypeJeu ;

    public function __construct($Id , $nom ){
        $this -> IdTypeJeu = $Id ;
        $this -> NomTypeJeu = $nom ;
    }

    public function getIdTypeJeu(){
        return $this -> IdTypeJeu;
    }

    public function getNomTypeJeu(){
        return $this -> NomTypeJeu;
    }

    public function setIdTypeJeu($id){
        $this -> IdTypeJeu = $id;
    }
    public function setNomTypeJeu($nom){
        $this -> NomTypeJeu = $nom;
    }
}