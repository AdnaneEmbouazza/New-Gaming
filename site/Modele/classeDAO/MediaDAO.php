<?php
include_once __DIR__ . "/PostgreSQLDB.php";
include_once __DIR__ . "/../classeMetier/Media.php";
class MediaDAO
{
    private PDO $pdomedia;

    public function __construct()
    {
        $this->pdomedia = PostgreSQLDB::getConnexion();
    }

    public function getMediaJeuByIdJeu($idJeu): array
    {
        try {
            $request = $this->pdomedia->prepare("SELECT * FROM mediajeu WHERE idJeu = :idJeu");
            $request->bindValue(':idJeu', $idJeu, PDO::PARAM_STR);
            $request->execute();

            $tabJeu = [];
            while ($resultMedia = $request->fetch(PDO::FETCH_ASSOC)) {
                $media = new Media($resultMedia['idmedia'], $resultMedia['cheminmedia'], $resultMedia['idjeu']); // création d'objet média
                $tabJeu[] = $media; // ajout de l'objet média dans le tableau
            }
            return $tabJeu;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des médias : " . $e->getMessage());
        }
    }

    public function getAllMedia(): array
    {
        try {
            $request = $this->pdomedia->prepare("SELECT * FROM mediajeu");
            $request->execute();
            $tabMedia = $request->fetchAll(PDO::FETCH_ASSOC);

            $medias = [];
            foreach ($tabMedia as $media) {
                $medias[] = new Media( // création d'objet média dans le tableau
                    $media["idmedia"],
                    $media["cheminmedia"],
                    $media["idjeu"]
                );
            }

            return $medias;
        } catch (PDOException $e) {
            print "ERREUR MESSAGE!: " . $e->getMessage();
            return [];
        }
    }

    public function getMediaAfficheById($idJeu): ?Media
    {
        $mediaAffiche = $this->getMediaJeuByIdJeu($idJeu);
        foreach ($mediaAffiche as $media) {
            if (strpos($media->getCheminMedia(), 'affiche') !== false) { // Vérifie si le chemin contient 'affiche'
                return $media;
            }
        }
        return null;
    }

    public function getAllMediaAffiche(): array
    {
        try {
            $request = $this->pdomedia->prepare("SELECT DISTINCT ON (idJeu) * FROM mediajeu WHERE CheminMedia LIKE '%affiche.jpg'"); // Récupère les médias avec 'affiche.jpg'
            $request->execute();
            $tabMedia = $request->fetchAll(PDO::FETCH_ASSOC);

            $medias = [];
            foreach ($tabMedia as $media) {
                // Indexer par idJeu pour faciliter l'accès dans la vue
                $medias[$media['idjeu']] = new Media(
                    $media['idmedia'],
                    $media['cheminmedia'],
                    $media['idjeu']
                );
            }

            return $medias;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des médias affiches : " . $e->getMessage());
        }
    }

    public function getAllMediaSaufAffiche(): array
    {
        try {
            $request = $this->pdomedia->prepare("SELECT * FROM mediajeu WHERE CheminMedia NOT LIKE '%affiche.jpg'"); // Récupère les médias qui ne sont pas des affiches
            $request->execute();
            $tabMedia = $request->fetchAll(PDO::FETCH_ASSOC);

            $medias = [];
            foreach ($tabMedia as $media) { // création d'objet média dans le tableau
                $medias[] = new Media(
                    $media["idmedia"],
                    $media["cheminmedia"],
                    $media["idjeu"]
                );
            }

            return $medias;
        } catch (PDOException $e) {
            print "ERREUR MESSAGE!: " . $e->getMessage();
            return [];
        }
    }

    public function ajouterMedia($idJeu, $cheminMedia)
    {
        // Générer un ID unique pour le média
        $idMedia = uniqid('media_', true);

        try {
            // Préparer la requête d'insertion
            $sql = "INSERT INTO MediaJeu (IdMedia, CheminMedia, IdJeu) VALUES (:idMedia, :cheminMedia, :idJeu)";
            $stmt = $this->pdomedia->prepare($sql);

            // Lier les paramètres à la requête
            $stmt->bindParam(':idMedia', $idMedia, PDO::PARAM_STR);
            $stmt->bindParam(':cheminMedia', $cheminMedia, PDO::PARAM_STR);
            $stmt->bindParam(':idJeu', $idJeu, PDO::PARAM_STR);

            // Exécuter la requête
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout du média : " . $e->getMessage();
            die();
        }
    }
}