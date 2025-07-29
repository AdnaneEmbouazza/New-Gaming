<?php

class Media {
    private string $IdMedia;
    private string $CheminMedia;
    private string $IdJeu;

    public function __construct($Id, $chemin, $IdJeu) {
        $this->IdMedia = $Id;
        $this->CheminMedia = $chemin;
        $this->IdJeu = $IdJeu;
    }

    public function getIdMedia(): string {
        return $this->IdMedia;
    }

    public function getCheminMedia(): string {
        return $this->CheminMedia;
    }

    public function getIdJeu(): string {
        return $this->IdJeu;
    }

    public function setIdMedia(string $Id): void {
        $this->IdMedia = $Id;
    }

    public function setCheminMedia(string $chemin): void {
        $this->CheminMedia = $chemin;
    }

    public function setIdJeu(string $IdJeu): void {
        $this->IdJeu = $IdJeu;
    }
}