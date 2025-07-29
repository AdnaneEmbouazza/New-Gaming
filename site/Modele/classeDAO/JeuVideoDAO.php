<?php
include_once __DIR__ . "/PostgreSQLDB.php";
include_once __DIR__ . "/../classeMetier/JeuVideo.php";
class JeuVideoDao
{
    private PDO $pdoJeu;


    public function __construct()
    {
        // Connexion à la base de données via Singleton
        $this->pdoJeu = PostgreSQLDB::getConnexion();
    }


    public function getJeuById($idJeu): JeuVideo
    {
        try {
            $request = $this->pdoJeu->prepare("SELECT * FROM jeuvideo WHERE idJeu = :idJeu"); // Prépare la requête pour récupérer les données de la table jeuvideo en fonction du paramètre
            $request->bindValue(':idJeu', $idJeu, PDO::PARAM_STR);// Lie les valeurs avec les paramètres
            $request->execute(); // execute la requete
            $resultJeu = $request->fetch(PDO::FETCH_ASSOC); // la transforme sous forme de tableau associatif
        } catch (PDOException $e) {
            print "ERREUR MESSAGE!: " . $e->getMessage();
            die();
        }
        return new JeuVideo($resultJeu["idjeu"], $resultJeu["nomjeu"], $resultJeu["dateparution"], $resultJeu["nomdev"],
            $resultJeu["nomediteur"], $resultJeu["descriptionjeu"], $resultJeu["prix"], $resultJeu["restrictionage"]);
    } // retourne un objet JeuVideo

    public function getAllJeu(): array
    {
        try {
            $request = $this->pdoJeu->prepare("SELECT * FROM jeuvideo");
            $request->execute();
            $tabJeu = $request->fetchAll(PDO::FETCH_ASSOC); // Récupère toutes les lignes en une seule fois

            $jeux = [];
            foreach ($tabJeu as $jeu) {
                $jeux[] = new JeuVideo( // crée un tableau d'objets JeuVideo
                    $jeu["idjeu"],
                    $jeu["nomjeu"],
                    $jeu["dateparution"],
                    $jeu["nomdev"],
                    $jeu["nomediteur"],
                    $jeu["descriptionjeu"],
                    $jeu["prix"],
                    $jeu["restrictionage"]
                );
            }

            return $jeux;
        } catch (PDOException $e) {
            print "ERREUR MESSAGE!: " . $e->getMessage();
            return []; // Retourne un tableau vide en cas d'erreur
        }
    }

    public function getJeuByNom($nomJeu): JeuVideo
    {
        try {
            $request = $this->pdoJeu->prepare("SELECT * FROM jeuvideo WHERE nomJeu = :nomjeu"); // Prépare la requête pour récupérer les données de la table jeuvideo en fonction du paramètre
            $request->bindValue(':nomjeu', $nomJeu, PDO::PARAM_STR);// Lie les valeurs avec les paramètres
            $request->execute(); // execute la requete
            $resultJeu = $request->fetch(PDO::FETCH_ASSOC); // la transforme sous forme de tableau associatif
        } catch (PDOException $e) {
            print "ERREUR MESSAGE!: " . $e->getMessage();
            die();
        }
        return new JeuVideo($resultJeu["idjeu"], $resultJeu["nomjeu"], $resultJeu["dateparution"], $resultJeu["nomdev"],
            $resultJeu["nomediteur"], $resultJeu["descriptionjeu"], $resultJeu["prix"], $resultJeu["restrictionage"]); // retourne un objet JeuVideo
    }

    public function addJeu($jeu): bool
    {
        try {
            $request = $this->pdoJeu->prepare("INSERT INTO jeuvideo (idJeu, nomJeu, dateParution, nomDev, nomEditeur, descriptionJeu, prix, restrictionAge) 
            VALUES (:idJeu, :nomJeu, :dateParution, :nomDev, :nomEditeur, :descriptionJeu, :prix, :restrictionAge)"); // Prépare la requête pour insérer les données dans la table jeuvideo
            $request->bindValue(':idJeu', $jeu->getIdJeu(), PDO::PARAM_STR);
            $request->bindValue(':nomJeu', $jeu->getNomJeu(), PDO::PARAM_STR);
            $request->bindValue(':dateParution', $jeu->getDateParution(), PDO::PARAM_STR);
            $request->bindValue(':nomDev', $jeu->getDeveloppeur(), PDO::PARAM_STR);
            $request->bindValue(':nomEditeur', $jeu->getEditeur(), PDO::PARAM_STR);
            $request->bindValue(':descriptionJeu', $jeu->getDescriptionJeu(), PDO::PARAM_STR);
            $request->bindValue(':prix', $jeu->getPrix(), PDO::PARAM_STR);
            $request->bindValue(':restrictionAge', $jeu->getRestrictionAge(), PDO::PARAM_INT);

            return $request->execute();
        } catch (PDOException $e) {
            print "ERREUR MESSAGE!: " . $e->getMessage();
            return false;
        }
    }

    public function deleteJeu($idJeu): bool
    {
        try {
            $request = $this->pdoJeu->prepare("DELETE FROM jeuvideo WHERE idJeu = :idJeu"); // Prépare la requête pour supprimer les données de la table jeuvideo en fonction du paramètre
            $request->bindValue(':idJeu', $idJeu, PDO::PARAM_STR);
            return $request->execute();
        } catch (PDOException $e) {
            print "ERREUR MESSAGE!: " . $e->getMessage();
            return false;
        }
    }

    public function updateJeu($jeu): bool
    {
        try {
            $request = $this->pdoJeu->prepare("UPDATE jeuvideo SET nomJeu = :nomJeu, dateParution = :dateParution, nomDev = :nomDev, nomEditeur = :nomEditeur, descriptionJeu = :descriptionJeu, prix = :prix, restrictionAge = :restrictionAge WHERE idJeu = :idJeu");
            // Prépare la requête pour mettre à jour les données de la table jeuvideo en fonction du paramètre
            $request->bindValue(':idJeu', $jeu->getIdJeu(), PDO::PARAM_STR);
            $request->bindValue(':nomJeu', $jeu->getNomJeu(), PDO::PARAM_STR);
            $request->bindValue(':dateParution', $jeu->getDateParution(), PDO::PARAM_STR);
            $request->bindValue(':nomDev', $jeu->getDeveloppeur(), PDO::PARAM_STR);
            $request->bindValue(':nomEditeur', $jeu->getEditeur(), PDO::PARAM_STR);
            $request->bindValue(':descriptionJeu', $jeu->getDescriptionJeu(), PDO::PARAM_STR);
            $request->bindValue(':prix', $jeu->getPrix(), PDO::PARAM_STR);
            $request->bindValue(':restrictionAge', $jeu->getRestrictionAge(), PDO::PARAM_INT);

            return $request->execute();
        } catch (PDOException $e) {
            print "ERREUR MESSAGE!: " . $e->getMessage();
            return false;
        }
    }

    public function rechercherJeux(string $terme): array {
        try {
            $requete = $this->pdoJeu->prepare(
                "SELECT * FROM jeuvideo 
             WHERE LOWER(nomjeu) LIKE LOWER(:termeDebut)
             ORDER BY nomjeu ASC" // selectionne les jeux par ordre alphabétique et en fonction du contenu de la recherche (pour la barre de recherche)
            );

            $termeDebut = $terme . "%"; // s'assure que la recherche commence par le terme donné
            $requete->execute([':termeDebut' => $termeDebut]);

            $jeux = [];
            while ($ligne = $requete->fetch(PDO::FETCH_ASSOC)) {
                $jeux[] = new JeuVideo( // crée un tableau d'objets JeuVideo
                    $ligne["idjeu"],
                    $ligne["nomjeu"],
                    $ligne["dateparution"],
                    $ligne["nomdev"],
                    $ligne["nomediteur"],
                    $ligne["descriptionjeu"],
                    $ligne["prix"],
                    $ligne["restrictionage"]
                );
            }
            return $jeux;
        } catch (PDOException $e) {
            print "ERREUR MESSAGE!: " . $e->getMessage();
            return []; // Retourne un tableau vide en cas d'erreur
        }
    }

}