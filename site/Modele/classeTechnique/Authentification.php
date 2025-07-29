<?php

include_once __DIR__ . "/../classeDAO/UtilisateurDAO.php";

class Authentification {
    private UtilisateurDAO $utilisateurDAO;

    public function __construct() {
        $this->utilisateurDAO = new UtilisateurDAO();
    }

    public function validateFormat($mailU, $pseudoU, $mdpU, $ageU): array {
        $errors = [];

        // Validation email
        if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $mailU)) {
            $errors[] = "Format d'email invalide";
        }

        // Validation pseudo (lettres, chiffres, 3-20 caractères)
        if (!preg_match('/^[a-zA-Z0-9]{3,20}$/', $pseudoU)) {
            $errors[] = "Le pseudo doit contenir entre 3 et 20 caractères alphanumériques";
        }

        // Validation mot de passe (8 caractères min, 1 majuscule, 1 chiffre)
        if (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $mdpU)) {
            $errors[] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule et un chiffre";
        }

        // Validation âge
        if ($ageU < 13 || $ageU > 100) {
            $errors[] = "L'âge doit être entre 13 et 100 ans";
        }

        return $errors;
    }

    public function register($mailU, $pseudoU, $mdpU, $ageU): bool {
        if (!isset($_SESSION)) {
            session_start();
        }

        try {
            $errors = $this->validateFormat($mailU, $pseudoU, $mdpU, $ageU); // Validation des données

            if ($this->utilisateurDAO->getUserByMail($mailU)) {
                $errors[] = "Cet email est déjà utilisé"; // Vérification de l'unicité de l'email
            }

            if (!empty($errors)) {
                foreach ($errors as $error) { // Affichage des erreurs
                    print "- " . htmlspecialchars($error) . "<br>";
                }
                $_SESSION['erreurs'] = $errors;
                return false;
            }

            $resultat = $this->utilisateurDAO->addUser($mailU, $pseudoU, $ageU, $mdpU); // Insertion de l'utilisateur
            return $resultat;
        } catch (Exception $e) {
            return false;
        }
    }

    public function login($mailU, $mdpU): bool {
        if (!isset($_SESSION)) {
            session_start();
        }

        try {

            $utilisateur = $this->utilisateurDAO->getUserByMail($mailU); // Récupération de l'utilisateur par son email

            if ($utilisateur) { // Vérification de l'existence de l'utilisateur
                if (password_verify($mdpU, $utilisateur->getMdpU())) { // Vérification du mot de passe
                    $_SESSION["mailU"] = $mailU; // Stockage de l'email dans la session
                    $_SESSION["mdpU"] = $mdpU; // Stockage du mot de passe dans la session
                    // Sérialiser l'utilisateur complet
                    $_SESSION['utilisateur'] = serialize($utilisateur);
                    return true;
                }
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    public function isLoggedOn(): bool {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION["mailU"]) || !isset($_SESSION["mdpU"])) { // Vérification de l'existence de la session
            return false;
        }

        try {
            $utilisateur = $this->utilisateurDAO->getUserByMail($_SESSION["mailU"]); // Récupération de l'utilisateur par son email
            return $utilisateur->getMailU() === $_SESSION["mailU"]
                && password_verify($_SESSION["mdpU"], $utilisateur->getMdpU()); // Vérification de l'email et du mot de passe
        } catch (Exception $e) {
            print("Erreur de vérification : " . $e->getMessage());
            return false;
        }
    }

    public function logout(): void {
        if (!isset($_SESSION)) {
            session_start();
        }
        session_unset(); // Libération de toutes les variables de session
        session_destroy(); // Destruction de la session
    }
}