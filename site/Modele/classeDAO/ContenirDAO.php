<?php
require_once __DIR__ . "/PostgreSQLDB.php";

class ContenirDAO {
    private PDO $pdoContenir;

    public function __construct() {
        $this->pdoContenir = PostgreSQLDB::getConnexion();
    }

    public function insererJeuxCommande(string $idCommande, array $idsJeux): bool {
        try {
            $requete = $this->pdoContenir->prepare(
                "INSERT INTO Contenir (IdJeu, IdCommande) 
                 VALUES (:idJeu, :idCommande)"
            );

            $this->pdoContenir->beginTransaction(); // s'assure que soit toute la transaction est effectuée, soit rien n'est fait

            foreach ($idsJeux as $idJeu) {
                $requete->execute([
                    ':idJeu' => $idJeu,
                    ':idCommande' => $idCommande
                ]);
            }

            return $this->pdoContenir->commit(); // valide la transaction si tout s'est bien passé
        } catch (PDOException $e) {
            $this->pdoContenir->rollBack(); // annule la transaction en cas d'erreur
            print "ERREUR MESSAGE!: " . $e->getMessage();
            return false;
        }
    }
}