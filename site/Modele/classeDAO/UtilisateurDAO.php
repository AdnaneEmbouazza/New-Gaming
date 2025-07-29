<?php

include_once __DIR__ . "/PostgreSQLDB.php"; // Inclusion de la classe PostgreSQLDB
include_once __DIR__ . "/../classeMetier/Utilisateur.php";
include_once __DIR__ . "/../classeMetier/JeuVideo.php";
include_once __DIR__ . "/../classeMetier/Commande.php";
class UtilisateurDAO{

    private PDO $pdoUser;

    public function __construct()
    {
        // Connexion à la base de données via Singleton
        $this->pdoUser = PostgreSQLDB::getConnexion();
    }

    public function getUserByMail($mailU): ?Utilisateur { // charge l'utilisateur , ses commandes et ses jeux par son mail
        try {
            // Récupérer l'utilisateur
            $request = $this->pdoUser->prepare("SELECT * FROM utilisateur WHERE mailu = :mailu");
            $request->bindValue(':mailu', $mailU, PDO::PARAM_STR);
            $request->execute();
            $resultUser = $request->fetch(PDO::FETCH_ASSOC);

            if (!$resultUser) {
                return null;
            }

            // Créer l'objet utilisateur
            $utilisateur = new Utilisateur(
                $resultUser["mailu"],
                $resultUser["pseudou"],
                $resultUser["ageu"],
                $resultUser["mdpu"],
                (bool)$resultUser["admin"]
            );

            // Charger ses commandes
            $requeteCommandes = $this->pdoUser->prepare(
                "SELECT c.idcommande, c.datecommande 
             FROM Commande c 
             WHERE c.mailU = :mailU"
            );
            $requeteCommandes->execute([':mailU' => $mailU]);

            while ($commande = $requeteCommandes->fetch(PDO::FETCH_ASSOC)) {
                $nouvelleCommande = new Commande( // Création de ses commandes en objet
                    $commande['idcommande'],
                    $commande['datecommande'],
                    $utilisateur,
                    $mailU
                );

                // Charger les jeux de chaque commande
                $requeteJeux = $this->pdoUser->prepare(
                    "SELECT j.* 
                 FROM JeuVideo j
                 INNER JOIN Contenir co ON j.IdJeu = co.IdJeu
                 WHERE co.IdCommande = :idCommande"
                );
                $requeteJeux->execute([':idCommande' => $commande['idcommande']]);

                while ($jeu = $requeteJeux->fetch(PDO::FETCH_ASSOC)) {
                    $nouveauJeu = new JeuVideo( // Création de ses jeux en objet
                        $jeu['idjeu'],
                        $jeu['nomjeu'],
                        $jeu['dateparution'],
                        $jeu['nomdev'],
                        $jeu['nomediteur'],
                        $jeu['descriptionjeu'],
                        $jeu['prix'],
                        $jeu['restrictionage']
                    );
                    $nouvelleCommande->addJeu($nouveauJeu);
                }

                $utilisateur->addCommande($nouvelleCommande);
            }

            return $utilisateur;

        } catch (PDOException $e) {
            print("Erreur dans getUserByMail : " . $e->getMessage());
            throw new Exception("Erreur lors de la récupération de l'utilisateur");
        }
    }

    public function getAllUser(){
        try {
            $request = $this->pdoUser->prepare("SELECT * FROM utilisateur"); // Prépare la requête pour récupérer les données de la table utilisateur
            $request->execute(); // execute la requete
            $resultUser = $request->fetchAll(PDO::FETCH_ASSOC); // la transforme sous forme de tableau associatif
        } catch (PDOException $e) {
            print "ERREUR MESSAGE!: " . $e->getMessage();
            die();
        }
        return $resultUser;
    }

    public function addUser($mailU, $pseudoU, $ageU, $mdpU): bool {
        try {
            $mdpHash = password_hash($mdpU, PASSWORD_DEFAULT);

            $request = $this->pdoUser->prepare("INSERT INTO utilisateur (mailu, pseudou, ageu, mdpu, admin) VALUES (:mailu, :pseudou, :ageu, :mdpu, FALSE)"); // Prépare la requête pour insérer les données dans la table utilisateur
            $request->bindValue(':mailu', $mailU, PDO::PARAM_STR);
            $request->bindValue(':pseudou', $pseudoU, PDO::PARAM_STR);
            $request->bindValue(':ageu', $ageU, PDO::PARAM_INT);
            $request->bindValue(':mdpu', $mdpHash, PDO::PARAM_STR);

            $resultat = $request->execute();

            return $resultat;
        } catch (PDOException $e) {
            print("Erreur d'insertion : " . $e->getMessage());
            return false;
        }
    }

    public function deleteUserByMail($mailU){
        try {
            $request = $this->pdoUser->prepare("DELETE FROM utilisateur WHERE mailU = :mailU"); // supprime l'utilisateur de la table utilisateur
            $request->bindValue(':mailU', $mailU, PDO::PARAM_STR);
            return $request->execute();
        } catch (PDOException $e) {
            error_log("Erreur de suppression : " . $e->getMessage());
            return false;
        }
    }

    public function updateJeuxUtilisateur(string $mailU): void {
        try {
            // Récupérer tous les jeux de l'utilisateur via les commandes
            $requete = $this->pdoUser->prepare(
                "SELECT j.*, c.note, c.commentaire 
             FROM JeuVideo j
             INNER JOIN Contenir co ON j.IdJeu = co.IdJeu
             INNER JOIN Commande cm ON co.IdCommande = cm.IdCommande
             LEFT JOIN Critiquer c ON j.IdJeu = c.IdJeu AND c.mailU = :mailU
             WHERE cm.mailU = :mailU"
            );

            $requete->execute([':mailU' => $mailU]);
            $jeux = $requete->fetchAll(PDO::FETCH_ASSOC);

            $utilisateur = $this->getUserByMail($mailU); // Récupérer l'utilisateur par son mail
            if ($utilisateur) {
                require_once __DIR__ . "/CritiquerDAO.php";
                $critiquerDAO = new CritiquerDAO();

                foreach ($jeux as $jeu) {
                    $nouveauJeu = new JeuVideo(
                        $jeu['idjeu'],
                        $jeu['nomjeu'],
                        $jeu['dateparution'],
                        $jeu['nomdev'],
                        $jeu['nomediteur'],
                        $jeu['descriptionjeu'],
                        $jeu['prix'],
                        $jeu['restrictionage']
                    );
                    $utilisateur->addJeu($nouveauJeu , $critiquerDAO); // pour ajouter les jeux au tableau $MesJeux de la classe Utilisateur
                }
            }
        } catch (PDOException $e) {
            print "ERREUR MESSAGE!: " . $e->getMessage();
        }
    }

    public function updateUserInfo($mailU, $newPseudo = null, $newPassword = null): bool {
        try {
            $updates = [];
            $params = [':mailU' => $mailU];

            // Gestion du pseudo
            if ($newPseudo !== null && !empty(trim($newPseudo))) { // Vérifie si le pseudo n'est pas vide
                $updates[] = "pseudou = :pseudo"; // On prépare la mise à jour du pseudo
                $params[':pseudo'] = trim($newPseudo); // On enlève les espaces avant et après
            }

            // Gestion du mot de passe
            if ($newPassword !== null && !empty(trim($newPassword))) { // Vérifie si le mot de passe n'est pas vide
                $updates[] = "mdpu = :mdp"; // On prépare la mise à jour du mot de passe
                $params[':mdp'] = password_hash(trim($newPassword), PASSWORD_DEFAULT); // On hash le mot de passe
            }

            // Si aucune mise à jour n'est nécessaire
            if (empty($updates)) {
                return false;
            }

            $sql = "UPDATE utilisateur SET " . implode(', ', $updates). " WHERE mailu = :mailU";
            $request = $this->pdoUser->prepare($sql);

            if ($request->execute($params)) {
                // Mise à jour de l'utilisateur en session si le pseudo a été modifié
                if (isset($params[':pseudo'])) {
                    $utilisateur = unserialize($_SESSION['utilisateur']);
                    $utilisateur->setPseudoU($params[':pseudo']);
                    $_SESSION['utilisateur'] = serialize($utilisateur);
                }
                return true;
            }
            return false;

        } catch (PDOException $e) {
            error_log("Erreur lors de la mise à jour de l'utilisateur : " . $e->getMessage());
            return false;
        }
    }
}