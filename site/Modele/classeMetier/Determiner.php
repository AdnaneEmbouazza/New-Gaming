<?php

class Determiner
{
    private string $idType;
    private string $idJeu;
    private ?string $nomTypeJeu;

    public function __construct($idType ,$idJeu, ?string $nomTypeJeu = null)
    {
        $this->idType = $idType;
        $this->idJeu = $idJeu;
        $this->nomTypeJeu = $nomTypeJeu;
    }

    public function getIdJeu()
    {
        return $this->idJeu;
    }

    public function getIdType()
    {
        return $this->idType;
    }

    public function setIdJeu($idJeu)
    {
        $this->idJeu = $idJeu;
    }

    public function setIdType($idType)
    {
        $this->idType = $idType;
    }

    public function getNomTypeJeu()
    {
        return $this->nomTypeJeu;
    }

    public function setNomTypeJeu($nomTypeJeu)
    {
        $this->nomTypeJeu = $nomTypeJeu;
    }

    public function __toString()
    {
        return "idJeu: " . $this->idJeu . ", idType: " . $this->idType . ", nomTypeJeu: " . $this->nomTypeJeu;
    }
}