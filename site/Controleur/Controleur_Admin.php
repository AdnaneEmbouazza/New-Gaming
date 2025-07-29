<?php
require_once "Modele/classeDAO/JeuVideoDAO.php";
require_once "Modele/classeDAO/TypeJeuDAO.php";
require_once "Modele/classeDAO/MediaDAO.php";
//require_once "Modele/classeDAO/DeterminerDAO.php";

class Controleur_Admin
{
    private JeuVideoDAO $jeuVideoDAO;
    private TypeJeuDAO $typeJeuDAO;
    private MediaDAO $mediaDAO;

//    private DeterminerDAO $DeterminerDAO;

    public function __construct()
    {
        $this->jeuVideoDAO = new JeuVideoDAO();
        $this->typeJeuDAO = new TypeJeuDAO();
        $this->mediaDAO = new MediaDAO();
//        $this->DeterminerDAO = new DeterminerDAO();
    }

    public function afficherPanneauAdmin(): void
    {
        if (!isset($_SESSION['utilisateur'])) {
            header('Location: index.php?action=connexion');
            exit();
        }

        require_once('Modele/classeMetier/Utilisateur.php');
        $utilisateur = unserialize($_SESSION['utilisateur']);
        if (!$utilisateur->isAdmin()) {
            header('Location: index.php?action=accueil');
            exit();
        }

        $jeux = $this->jeuVideoDAO->getAllJeu();
        $types = $this->typeJeuDAO->getAllTypeJeu();

        require_once('Vue/vue.admin.php');
    }

    public function ajouterJeu(): void
    {
        // Vérification des droits admin
        if (!$this->verifierAdmin()) return;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération des données du formulaire
            $nomJeu = $_POST['nomJeu'] ?? '';
            $dateParution = $_POST['dateParution'] ?? '';
            $developpeur = $_POST['developpeur'] ?? '';
            $editeur = $_POST['editeur'] ?? '';
            $description = $_POST['description'] ?? '';
            $prix = $_POST['prix'] ?? 0;
            $restrictionAge = $_POST['restrictionAge'] ?? 0;

            // Génération d'un idJeu unique (ex: jeu_661e8d123abc)
            $idJeu = uniqid('jeu_');

            // Création de l'objet JeuVideo
            $jeu = new JeuVideo(
                $idJeu,
                $nomJeu,
                $dateParution,
                $developpeur,
                $editeur,
                $description,
                $prix,
                $restrictionAge
            );

            // Appel à la méthode d'insertion
            $resultat = $this->jeuVideoDAO->addJeu($jeu);

            if ($resultat) {
                $_SESSION['message'] = "Jeu ajouté avec succès";
            } else {
                $_SESSION['erreur'] = "Erreur lors de l'ajout du jeu";
            }
        }

        // Redirection vers la page admin
        header('Location: index.php?action=admin');
    }


    private function verifierAdmin(): bool
    {
        if (!isset($_SESSION['utilisateur'])) {
            header('Location: index.php?action=connexion');
            return false;
        }

        require_once('Modele/classeMetier/Utilisateur.php');
        $utilisateur = unserialize($_SESSION['utilisateur']);
        if (!$utilisateur->isAdmin()) { // Vérification si l'utilisateur est admin
            header('Location: index.php?action=accueil');
            return false;
        }

        return true;
    }

    public function supprimerJeu(): void
    {
        // Vérification des droits admin
        if (!$this->verifierAdmin()) return;

        // Vérification si l'opération est "supprimerJeu" et si un "id" est présent dans l'URL
        if (isset($_GET['operation']) && $_GET['operation'] === 'supprimerJeu' && isset($_GET['idjeu'])) {
            $idJeu = $_GET['idjeu']; // Récupération de l'id du jeu à supprimer

            // Appel à la méthode du modèle pour supprimer le jeu
            $resultat = $this->jeuVideoDAO->deleteJeu($idJeu);

            // Message de confirmation ou d'erreur
            if ($resultat) {
                $_SESSION['message'] = "Jeu supprimé avec succès";
            } else {
                $_SESSION['erreur'] = "Erreur lors de la suppression du jeu";
            }

            // Redirection vers la page admin
            header('Location: index.php?action=admin');
            exit;
        }
    }


    public function modifierJeu(): void
    {
        // Vérification des droits admin
        if (!$this->verifierAdmin()) return;

        // Vérification si l'ID du jeu est passé dans l'URL
        if (isset($_GET['idjeu'])) {
            $idJeu = $_GET['idjeu'];

            // Si le formulaire a été soumis
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Récupération des données du formulaire
                $nomJeu = $_POST['nomJeu'] ?? '';
                $dateParution = $_POST['dateParution'] ?? '';
                $developpeur = $_POST['developpeur'] ?? '';
                $editeur = $_POST['editeur'] ?? '';
                $description = $_POST['description'] ?? '';
                $prix = $_POST['prix'] ?? 0;
                $restrictionAge = $_POST['restrictionAge'] ?? 0;

                // Création de l'objet JeuVideo avec les nouvelles données
                $jeu = new JeuVideo(
                    $idJeu, // On garde l'ID du jeu existant
                    $nomJeu,
                    $dateParution,
                    $developpeur,
                    $editeur,
                    $description,
                    $prix,
                    $restrictionAge
                );

                // Appel de la méthode updateJeu() du modèle pour mettre à jour le jeu
                $resultat = $this->jeuVideoDAO->updateJeu($jeu);

                // Message de confirmation ou d'erreur
                if ($resultat) {
                    $_SESSION['message'] = "Jeu mis à jour avec succès";
                } else {
                    $_SESSION['erreur'] = "Erreur lors de la mise à jour du jeu";
                }

                // Redirection vers la page admin
                header('Location: index.php?action=admin');
                exit;
            } else {
                // Si ce n'est pas une soumission de formulaire, on charge les données du jeu pour pré-remplir le formulaire
                $jeu = $this->jeuVideoDAO->getJeuById($idJeu);

                // Si le jeu n'existe pas
                if (!$jeu) {
                    $_SESSION['erreur'] = "Jeu introuvable";
                    header('Location: index.php?action=admin');
                    exit;
                }

                // Affichage de la vue pour modifier le jeu
                require_once('Vue/vue.modifierJeu.php');
            }
        } else {
            $_SESSION['erreur'] = "Aucun identifiant de jeu trouvé";
            header('Location: index.php?action=admin');
            exit;
        }
    }

    public function uploadMedia()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['media']) && isset($_POST['jeuId'])) {
            $jeuId = $_POST['jeuId'];
            $fichier = $_FILES['media'];

            // Vérifie s'il n'y a pas d'erreur dans l'upload
            if ($fichier['error'] !== UPLOAD_ERR_OK) {
                echo "Erreur lors de l'envoi du fichier.";
                return;
            }

            // Vérifie l'extension
            $extension = strtolower(pathinfo($fichier['name'], PATHINFO_EXTENSION));
            if ($extension !== 'jpg') { // si l'extension n'est pas jpg
                echo "Seuls les fichiers .jpg sont autorisés.";
                return;
            }

            // Récupère le nom du jeu
            require_once("Modele/classeDAO/JeuVideoDAO.php");
            $jeuDAO = new JeuVideoDAO();
            $jeu = $jeuDAO->getJeuById($jeuId);
            $nomJeu = $jeu->getNomJeu();

            // Crée le dossier cible
            $targetDirectory = "image/" . $nomJeu . "_image";
            if (!is_dir($targetDirectory)) {
                if (!mkdir($targetDirectory, 0755, true)) {
                    echo "Impossible de créer le dossier cible.";
                    return;
                }
            }

            // Définit le chemin final avec le nom d'origine
            $fileName = basename($fichier['name']);
            $targetPath = $targetDirectory . '/' . $fileName;

            // Déplace le fichier
            if (move_uploaded_file($fichier['tmp_name'], $targetPath)) {
                echo "Fichier uploadé avec succès !";

                // Enregistrement du chemin dans la base de données si nécessaire
                require_once("Modele/classeDAO/MediaDAO.php");
                $mediaDAO = new MediaDAO();
                $mediaDAO->ajouterMedia($jeuId, $targetPath);

            } else {
                echo "Erreur lors du téléchargement du fichier.";
            }
        } else {
            echo "Requête invalide.";
        }
    }

//    public function ajouterTypeJeu(): void
//    {
//        if (!$this->verifierAdmin()) return;
//
//        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//            $idTypeJeu = $_POST['idTypeJeu'] ?? '';
//            $nomTypeJeu = $_POST['nomTypeJeu'] ?? '';
//
//            // Vérification que les champs sont bien remplis
//            if (!empty($idTypeJeu) && !empty($nomTypeJeu)) {
//                // Appel à la méthode du DAO en passant les deux paramètres séparés
//                $resultat = $this->typeJeuDAO->addTypeJeu($nomTypeJeu, $idTypeJeu);
//
//                // Message de confirmation ou d'erreur
//                $_SESSION['message'] = $resultat
//                    ? "Type de jeu ajouté avec succès"
//                    : "Erreur lors de l'ajout du type de jeu";
//            } else {
//                $_SESSION['erreur'] = "Champs requis manquants";
//            }
//        }
//
//        // Redirection vers la page admin
//        header('Location: index.php?action=admin');
//        exit;
//    }


//    public function associerTypeJeu(): void
//    {
//        if (!$this->verifierAdmin()) return;
//
//        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//            $idJeu = $_POST['idJeu'] ?? '';
//            $idTypeJeu = $_POST['idTypeJeu'] ?? '';
//
//            if (!empty($idJeu) && !empty($idTypeJeu)) {
//                require_once("Modele/classeDAO/DeterminerDAO.php");
//                $this->DeterminerDAO = new DeterminerDAO();
//                $resultat = $this->DeterminerDAO->LinkTypeJeu($idJeu, $idTypeJeu);
//
//                if ($resultat) {
//                    $_SESSION['message'] = "Type associé au jeu avec succès.";
//                } else {
//                    $_SESSION['erreur'] = "Erreur lors de l'association du type.";
//                }
//            } else {
//                $_SESSION['erreur'] = "Champs manquants pour l'association.";
//            }
//        }
//
//        header('Location: index.php?action=admin');
//        exit;
//    }

}
