<?php

class CritiquerDAO
{
    private $pdoCritique;

    public function __construct()
    {
        $this->pdoCritique = PostgreSQLDB::getConnexion();
    }

    public function getCritiqueByIdJeu($idJeu): ?array
    {
        try {
            $request = $this->pdoCritique->prepare("SELECT c.*, u.pseudou
             FROM critiquer c 
             JOIN utilisateur u ON c.mailu = u.mailu 
             WHERE c.idjeu = :idJeu 
             ORDER BY c.datecritique DESC"); // Jointure pour egalement récuperer le pseudo de l'utilisateur

            $request->bindValue(':idJeu', $idJeu, PDO::PARAM_STR);
            $request->execute();
            $resultat = $request->fetchAll(PDO::FETCH_ASSOC); // Récupère toutes les lignes en une seule fois
            return $resultat;
        } catch (PDOException $e) {
            print "ERREUR MESSAGE!: " . $e->getMessage();
            return [];
        }
    }

    public function getAllCritiques(){
        try {
            $request = $this->pdoCritique->prepare("SELECT * FROM critiquer"); // Récupère toutes les critiques
            $request->execute();
            $resultat = $request->fetchAll(PDO::FETCH_ASSOC); // Récupère toutes les lignes en une seule fois
        }
        catch (PDOException $e) {
            print "ERREUR MESSAGE!: " . $e->getMessage();
            die();
        }
        return $resultat;
    }

    public function addCritique(string $mailU, string $idJeu, int $note, string $commentaire): bool {
        try {
            // Vérification si l'utilisateur n'a pas déjà commenté ce jeu
            $request = $this->pdoCritique->prepare(
                "SELECT COUNT(*) FROM critiquer WHERE mailu = :mailU AND idjeu = :idJeu"
            );
            $request->bindValue(':mailU', $mailU, PDO::PARAM_STR);
            $request->bindValue(':idJeu', $idJeu, PDO::PARAM_STR);
            $request->execute();

            if ($request->fetchColumn() > 0) {
                return false; // L'utilisateur a déjà commenté ce jeu
            }

            // Vérification de la note
            if ($note < 0 || $note > 20) {
                return false; // Note invalide
            }

            // Insertion de la critique
            $request = $this->pdoCritique->prepare(
                "INSERT INTO critiquer (mailu, idjeu, note, commentaire, datecritique)
             VALUES (:mailU, :idJeu, :note, :commentaire, CURRENT_DATE)"
            ); // On insère la critique avec la date actuelle

            $request->bindValue(':mailU', $mailU, PDO::PARAM_STR);
            $request->bindValue(':idJeu', $idJeu, PDO::PARAM_STR);
            $request->bindValue(':note', $note, PDO::PARAM_INT);
            $request->bindValue(':commentaire', $commentaire, PDO::PARAM_STR);

            return $request->execute();

        } catch (PDOException $e) {
            print("Erreur dans addCritique : " . $e->getMessage());
            return false;
        }
    }

    public function deleteCritique(string $mailU, string $idJeu): bool {
        try {
            $request = $this->pdoCritique->prepare(
                "DELETE FROM critiquer WHERE mailu = :mailU AND idjeu = :idJeu" // Supprime la critique du bon utilisateur et sur le bon jeu
            );

            $request->bindValue(':mailU', $mailU, PDO::PARAM_STR);
            $request->bindValue(':idJeu', $idJeu, PDO::PARAM_STR);

            return $request->execute();
        } catch (PDOException $e) {
            error_log("Erreur dans supprimerCritique : " . $e->getMessage());
            return false;
        }
    }

    public function updateCritique(string $mailU, string $idJeu, int $note, string $commentaire): bool {
        try {
            // Vérification de la note
            if ($note < 0 || $note > 20) {
                return false;
            }

            $request = $this->pdoCritique->prepare(
                "UPDATE critiquer 
             SET note = :note, 
                 commentaire = :commentaire, 
                 datecritique = CURRENT_DATE
             WHERE idjeu = :idJeu 
             AND mailu = :mailU"
            ); // On met à jour la critique avec la date actuelle

            $request->bindValue(':mailU', $mailU, PDO::PARAM_STR);
            $request->bindValue(':idJeu', $idJeu, PDO::PARAM_STR);
            $request->bindValue(':note', $note, PDO::PARAM_INT);
            $request->bindValue(':commentaire', $commentaire, PDO::PARAM_STR);

            return $request->execute();

        } catch (PDOException $e) {
            print("Erreur dans updateCritique : " . $e->getMessage());
            return false;
        }
    }
}