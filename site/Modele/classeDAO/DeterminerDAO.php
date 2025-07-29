<?php

include_once __DIR__ . "/PostgreSQLDB.php";
include_once __DIR__ . "/../classeMetier/Determiner.php";
class DeterminerDAO
{
    private PDO $pdoDetermine;

    public function __construct(){
        // Connexion à la base de données via Singleton
        $this->pdoDetermine = PostgreSQLDB::getConnexion();
    }

    public function getDeterminerbyIdJeu($idJeu){
        $request = $this->pdoDetermine->prepare("SELECT determiner.IdTypeJeu, IdJeu , NomTypeJeu FROM TypeJeu JOIN Determiner ON TypeJeu.IdTypeJeu = Determiner.IdTypeJeu 
        WHERE Determiner.IdJeu = :idJeu"); // Jointure pour également récupérer le nom du type de jeu
        $request->bindValue(':idJeu', $idJeu, PDO::PARAM_STR);
        $request->execute();

        $types = [];
        while ($resultType = $request->fetch(PDO::FETCH_ASSOC)) {
            $types[] = new Determiner( // Création d'objet Determiner dans le tableau
                $resultType["idtypejeu"],
                $resultType["idjeu"],
                $resultType["nomtypejeu"]
            );
        }
        return $types;
    }

    public function getallDeterminer(){
        $request = $this->pdoDetermine->prepare("SELECT * FROM determiner"); // selectionne tout dans la table determiner
        $request->execute();
        $tabDeter = $request->fetchAll(PDO::FETCH_ASSOC);

        $Determiner = [];
        foreach ($tabDeter as $Deter) { // On crée un tableau d'objet Determiner
            $Determiner[] = new Determiner(
                $Deter["idJeu"],
                $Deter["idType"]
            );
        }

        return $Determiner;
    }

    public function addDeterminer($idJeu, $idType):bool{
        $request = $this->pdoDetermine->prepare("INSERT INTO determiner (idJeu, idTypeJeu) VALUES (:idJeu, :idType)");
        $request->bindValue(':idJeu', $idJeu, PDO::PARAM_STR);
        $request->bindValue(':idTypeJeu', $idType, PDO::PARAM_STR);
        $resultat = $request->execute();

        return $resultat; // Retourne true si l'insertion a réussi, sinon false
    }

    public function deleteDeterminer($idJeu, $idType):bool{
        $request = $this->pdoDetermine->prepare("DELETE FROM determiner WHERE idJeu = :idJeu AND idTypeJeu = :idType");
        $request->bindValue(':idJeu', $idJeu, PDO::PARAM_STR);
        $request->bindValue(':idTypeJeu', $idType, PDO::PARAM_STR);
        $resultat = $request->execute();

        return $resultat; // Retourne true si l'insertion a réussi, sinon false
    }

    public function LinkTypeJeu(string $idJeu, string $idTypeJeu): bool
    {
        try {
            $sql = "INSERT INTO Determiner (IdJeu, IdTypeJeu) VALUES (:idJeu, :idTypeJeu)"; // Prépare la requête d'insertion
            $stmt = $this->pdoDetermine->prepare($sql);
            $stmt->bindValue(':idJeu', $idJeu, PDO::PARAM_STR);
            $stmt->bindValue(':idTypeJeu', $idTypeJeu, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erreur lors de l'association du type au jeu : " . $e->getMessage();
            return false;
        }
    }

}