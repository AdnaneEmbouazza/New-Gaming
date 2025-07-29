<?php

class Utilisateur {
    private string $mailU;
    private string $pseudoU;
    private string $mdpU;
    private int $ageU;
    private bool $admin;
    private array $mesJeux;
    private array $mesCommandes;

    public function __construct($mail, $pseudo, $ageu ,$mdp , $admin = false) {
        $this-> mailU = $mail ;
        $this -> pseudoU = $pseudo ;
        $this -> ageU = $ageu ;
        $this -> mdpU = $mdp ;
        $this->admin = $admin;
        $this -> mesJeux = [];
        $this -> mesCommandes = [];
    }

    public function isAdmin(): bool {
        return $this->admin;
    }

    public function getMailU(): string {
        return $this->mailU;
    }

    public function getPseudoU(): string {
        return $this->pseudoU;
    }

    public function getMdpU(): string {
        return $this->mdpU;
    }

    public function getAgeU(): int {
        return $this->ageU;
    }

    public function getMesJeux(): array {
        return $this->mesJeux;
    }


    public function getJeuWithCritique($idJeu): ?array {
        foreach ($this->mesJeux as $jeuData) {
            if ($jeuData['jeu']->getIdJeu() === $idJeu) {
                return $jeuData;
            }
        }
        return null;
    }

    public function getMesCommandes(): array {
        return $this->mesCommandes;
    }

    public function setMailU(string $mail): void {
        $this->mailU = $mail;
    }

    public function setPseudoU(string $pseudoU): void {
        $this->pseudoU = $pseudoU;
    }

    public function setMdpU(string $mdp): void {
        $this->mdpU = $mdp;
    }

    public function setMesJeux(array $mesJeux): void {
        $this->mesJeux = $mesJeux;
    }

    public function setMesCommandes(array $mesCommandes): void {
        $this->mesCommandes = $mesCommandes;
    }

    public function addJeu(JeuVideo $jeu, ?CritiquerDAO $critiqueurDAO = null): void {
        $critique = null;
        if ($critiqueurDAO !== null) {
            $critiques = $critiqueurDAO->getCritiqueByIdJeu($jeu->getIdJeu());
            // Cherche la critique de l'utilisateur courant
            if ($critiques) {
                foreach ($critiques as $crit) {
                    if ($crit['mailu'] === $this->mailU) {
                        $critique = $crit;
                        break;
                    }
                }
            }
        }

        $this->mesJeux[] = [ // On ajoute le jeu et la critique à la collection
            'jeu' => $jeu,
            'critique' => $critique
        ];
    }

    public function addCommande($commande): void {
        $this->mesCommandes[] = $commande;
    }

    public function removeJeu($jeuASupprimer): void {
        foreach ($this->mesJeux as $key => $jeuData) {
            if ($jeuData['jeu']->getIdJeu() === $jeuASupprimer->getIdJeu()) {
                unset($this->mesJeux[$key]);
                break;
            }
        }
        // Réindexe le tableau après la suppression
        $this->mesJeux = array_values($this->mesJeux);
    }

    public function removeCommande($commande): void {
        $key = array_search($commande, $this->mesCommandes);
        if ($key !== false) {
            unset($this->mesCommandes[$key]);
        }
    }

    public function __toString(): string {
        return "Mail Utilisateur:" . $this->mailU .   "Pseudonyme: " . $this->pseudoU . ", Age: " . $this->ageU;
    }

}