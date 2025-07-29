<?php

require_once __DIR__ . "/PostgreSQLDB.php";
require_once __DIR__ . "/../classeMetier/Commande.php";
class commandeDAO
{

    private PDO $pdoCommande;

    public function __construct()
    {
        // Connexion à la base de données via Singleton
        $this->pdoCommande = PostgreSQLDB::getConnexion();
    }

    public function getAllCommandes(): array
    {
        try {
            $request = $this->pdoCommande->prepare(
                "SELECT c.*, u.* 
             FROM commande c 
             INNER JOIN utilisateur u ON c.mailu = u.mailu" // la requete s'assure que l'utilisateur est bien associé a la bonne commande
            );
            $request->execute();
            $tabCommande = $request->fetchAll(PDO::FETCH_ASSOC);

            require_once __DIR__ . "/../classeMetier/Utilisateur.php";
            require_once __DIR__ . "/../classeMetier/Commande.php";

            $commandes = [];
            foreach ($tabCommande as $ligne) {
                // Création de l'objet utilisateur associé
                $utilisateur = new Utilisateur(
                    $ligne["mailu"],     // varchar(70)
                    $ligne["pseudou"],   // varchar(30)
                    $ligne["ageu"],      // integer
                    $ligne["mdpu"],      // varchar(255)
                    $ligne["admin"]      // boolean
                );

                // Création de la commande avec l'utilisateur
                $commandes[] = new Commande(
                    $ligne["idcommande"],
                    $ligne["datecommande"],
                    $utilisateur,
                    $ligne["mailu"]
                );
            }

            return $commandes;
        } catch (PDOException $e) {
            print "ERREUR MESSAGE!: " . $e->getMessage();
            return [];
        }
    }


    public function insertCommande(string $idCommande, string $dateCommande, string $mailU): bool {
        try {
            $requete = $this->pdoCommande->prepare(
                "INSERT INTO Commande (IdCommande, DateCommande, mailU)
             VALUES (:idCommande, :dateCommande, :mailU)" // On insère la commande avec l'utilisateur
            );

            $success = $requete->execute([
                ':idCommande' => $idCommande,
                ':dateCommande' => $dateCommande,
                ':mailU' => $mailU
            ]);

            if ($success) {
                // Récupérer l'utilisateur pour ajouter les jeux à la commande
                require_once __DIR__ . "/UtilisateurDAO.php";
                $utilisateurDAO = new UtilisateurDAO();
                $utilisateur = $utilisateurDAO->getUserByMail($mailU); // Récupérer l'utilisateur par son mail

                $nouvelleCommande = new Commande($idCommande, $dateCommande, $utilisateur, $mailU); // Créer une nouvelle commande


                // Ajouter les jeux de la commande (collection $lesJeux)
                require_once __DIR__ . "/JeuVideoDAO.php";
                $jeuVideoDAO = new JeuVideoDAO();
                foreach ($_SESSION['panier'] as $idJeu) {
                    $jeu = $jeuVideoDAO->getJeuById($idJeu);
                    if ($jeu) {
                        $nouvelleCommande->addJeu($jeu); // Ajoute le jeu à la collection de jeu de la classe commande
                    }
                }

                // Ajouter la commande à l'utilisateur
                $utilisateur->addCommande($nouvelleCommande);

                // Mettre à jour la session avec l'utilisateur modifié
                $_SESSION['utilisateur'] = serialize($utilisateur); // serialize: transforme l'objet utilisateur en chaîne de caractères
            }

            return $success;
        } catch (PDOException $e) {
            print "ERREUR MESSAGE!: " . $e->getMessage();
            return false;
        }
    }

    public function getCommandesByMail(Utilisateur $utilisateur): array {
        try {
            return $utilisateur->getMesCommandes(); // Récupérer les commandes de l'utilisateur
        } catch (PDOException $e) {
            print "ERREUR MESSAGE!: " . $e->getMessage();
            return [];
        }
    }

    public function deleteCommande(string $idCommande): bool {
        try {
            $requete = $this->pdoCommande->prepare(
                "DELETE FROM Commande WHERE IdCommande = :idCommande"
            ); // On supprime la commande

            return $requete->execute([':idCommande' => $idCommande]); // Exécute la requête de suppression
        } catch (PDOException $e) {
            print "ERREUR MESSAGE!: " . $e->getMessage();
            return false;
        }
    }
}