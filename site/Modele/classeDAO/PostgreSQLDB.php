<?php

/**
 * Class PostgreSQLDB
 * Gère la connexion à la base de données PostgreSQL en utilisant le pattern Singleton
 *
 * Cette classe fournit un point d'accès unique à la connexion PDO.
 * Elle utilise les variables d'environnement pour la configuration.
 */



final class PostgreSQLDB
{
    /** @var ?PDO Instance unique de connexion PDO */
    private static ?PDO $connexion = null;

    /**
     * Établit une connexion à la base de données PostgreSQL
     * Utilise les variables d'environnement :
     * - DB_HOST : hôte du serveur
     * - DB_PORT : port du serveur
     * - DB_TEST : nom de la base de données
     * - DB_USERNAME : nom d'utilisateur
     * - DB_PASSWORD : mot de passe
     *
     * @throws PDOException Si la connexion échoue
     */
    private static function connexionDB():void
    {
        $env = file(__DIR__ . '../../../../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($env as $line) {
    if (strpos(trim($line), '#') === 0) continue; // ignorer les commentaires
    [$key, $value] = explode('=', $line, 2);
    $_ENV[trim($key)] = trim($value);
}

// Récupérer les variables
$host = $_ENV['DB_HOST'] ?? 'localhost';
$port = $_ENV['DB_PORT'] ?? '5432';
$dbname = $_ENV['DB_NAME'] ?? '';
$user = $_ENV['DB_USERNAME'] ?? '';
$password = $_ENV['DB_PASSWORD'] ?? '';;

        try {
            self::$connexion = new PDO(
                sprintf(
                    "pgsql:host=%s;port=%s;dbname=%s;user=%s;password=%s",
                    $host,
                    $port,
                    $dbname,
                    $user,
                    $password
                    
                )
            );
//            print("Connexion à la base de données PostgreSQL réussie\n");
            self::$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            throw new PDOException("Erreur de connexion PDO : " . $e->getMessage());
        }
    }

    /**
     * Retourne l'instance unique de connexion PDO
     * Si la connexion n'existe pas, elle est créée
     *
     * @return PDO Instance de connexion PDO
     * @throws PDOException Si la connexion échoue
     */
    public static function getConnexion(): PDO
    {
        if (self::$connexion === null) {
            self::connexionDB();
        }
        return self::$connexion;
    }

}
