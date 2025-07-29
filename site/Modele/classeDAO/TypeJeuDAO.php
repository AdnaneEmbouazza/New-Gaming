<?php
include_once __DIR__ . "/../classeMetier/TypeJeu.php";
include_once __DIR__ . "/PostgreSQLDB.php";
class TypeJeuDAO{

    private PDO $pdoType;


    public function __construct()
    {
        // Connexion à la base de données via Singleton
        $this->pdoType = PostgreSQLDB::getConnexion();
    }

    public function getTypeJeuById($idTypeJeu): typeJeu
    {
        try {
            $request = $this->pdoType->prepare("SELECT * FROM typejeu WHERE idTypeJeu = :idTypeJeu"); // Prépare la requête pour récupérer les données de la table jeuvideo en fonction du paramètre
            $request->bindValue(':idTypeJeu', $idTypeJeu, PDO::PARAM_STR);// Lie les valeurs avec les paramètres
            $request->execute(); // execute la requete
            $resultTypeJeu = $request->fetch(PDO::FETCH_ASSOC); // la transforme sous forme de tableau associatif
        } catch (PDOException $e) {
            print "ERREUR MESSAGE!: " . $e->getMessage();
            die();
        }
        return new typeJeu($resultTypeJeu["idtypejeu"], $resultTypeJeu["nomtypejeu"]);
    }

    public function getNomTypeJeuById($idTypeJeu): string
    {
        try {
            $request = $this->pdoType->prepare("SELECT nomtypejeu FROM typejeu WHERE idTypeJeu = :idTypeJeu"); // Prépare la requête pour récupérer les données de la table typejeu en fonction du paramètre
            $request->bindValue(':idTypeJeu', $idTypeJeu, PDO::PARAM_STR); // Lie les valeurs avec les paramètres
            $request->execute(); // Exécute la requête
            $resultTypeJeu = $request->fetch(PDO::FETCH_ASSOC); // La transforme sous forme de tableau associatif
        } catch (PDOException $e) {
            print "ERREUR MESSAGE!: " . $e->getMessage();
            die();
        }
        return $resultTypeJeu["nomtypejeu"];
    }

    public function getAllTypeJeu(){
        try {
            $request = $this->pdoType->prepare("SELECT * FROM typejeu");
            $request->execute();
            $tabTypeJeu = $request->fetchAll(PDO::FETCH_ASSOC); // Récupère toutes les lignes en une seule fois

            $typeJeux = [];
            foreach ($tabTypeJeu as $type) {
                $typeJeux[] = new typeJeu(
                    $type["idtypejeu"],
                    $type["nomtypejeu"]
                );
            }
            return $typeJeux;
        } catch (PDOException $e) {
            print "ERREUR MESSAGE!: " . $e->getMessage();
            return []; // Retourne un tableau vide en cas d'erreur
        }
    }

    public function getallNomTypeJeu(){
        try {
            $request = $this->pdoType->prepare("SELECT nomtypejeu FROM typejeu");
            $request->execute();
            $tabTypeJeu = $request->fetchAll(PDO::FETCH_ASSOC); // Récupère toutes les lignes en une seule fois

            return $tabTypeJeu;
        } catch (PDOException $e) {
            print "ERREUR MESSAGE!: " . $e->getMessage();
            return []; // Retourne un tableau vide en cas d'erreur
        }
    }

    public function addTypeJeu($nomTypeJeu , $IdTypeJeu):bool{
        try {
            $request = $this->pdoType->prepare("INSERT INTO typejeu (idtypejeu ,nomtypejeu) VALUES (:IdTypeJeu, :nomTypeJeu)");
            $request->bindValue(':nomTypeJeu', $nomTypeJeu, PDO::PARAM_STR);
            $request->bindValue(':IdTypeJeu', $IdTypeJeu, PDO::PARAM_STR);
            $resultat = $request->execute();

            return $resultat; // Retourne true si l'insertion a réussi, sinon false
        } catch (PDOException $e) {
            print "ERREUR MESSAGE!: " . $e->getMessage();
            return false;
        }
    }

    public function deleteTypeJeu($idTypeJeu):bool{
        try {
            $request = $this->pdoType->prepare("DELETE FROM typejeu WHERE idtypejeu = :idTypeJeu");
            $request->bindValue(':idTypeJeu', $idTypeJeu, PDO::PARAM_STR);
            $resultat = $request->execute();
        } catch (PDOException $e) {
            print "ERREUR MESSAGE!: " . $e->getMessage();
            return false;
        }
        return $resultat; // Retourne true si la suppression a réussi, sinon false
    }

    public function updateTypeJeu($idTypeJeu, $nomTypeJeu):bool{
        try {
            $request = $this->pdoType->prepare("UPDATE typejeu SET nomtypejeu = :nomTypeJeu WHERE idtypejeu = :idTypeJeu");
            $request->bindValue(':nomTypeJeu', $nomTypeJeu, PDO::PARAM_STR);
            $request->bindValue(':idTypeJeu', $idTypeJeu, PDO::PARAM_STR);
            $resultat = $request->execute();
        } catch (PDOException $e) {
            print "ERREUR MESSAGE!: " . $e->getMessage();
            return false;
        }
        return $resultat; // Retourne true si la mise à jour a réussi, sinon false
    }

    public function getTypeJeuByNom($nomTypeJeu): ?TypeJeu
    {
        $request = $this->pdoType->prepare("SELECT * FROM typejeu WHERE nomtypejeu = :nomtypejeu");
        $request->bindValue(':nomtypejeu', $nomTypeJeu, PDO::PARAM_STR);
        $request->execute();
        $typeData = $request->fetch(PDO::FETCH_ASSOC);
        if ($typeData) {
            return new TypeJeu($typeData['idtypejeu'], $typeData['nomtypejeu']);
        }
        return null;  // Retourne null si le type n'est pas trouvé
    }

}