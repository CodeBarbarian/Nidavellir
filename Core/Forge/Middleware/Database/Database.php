<?php

namespace Core\Forge\Middleware\Database;

use PDO;
use PDOException;
use Exception;

abstract class Database extends PDO {
    /**
     * @var PDO|null Holds the single PDO instance for the database connection
     */
    private static ?PDO $DB = null;

    /**
     * Get the PDO database connection instance.
     *
     * @return PDO|null
     * @throws Exception if the database driver is unsupported or connection fails
     */
    public static function getDB(): ?PDO {
        if (!\App\Config\Database::USE_DATABASE) {
            return null;
        }

        if (self::$DB === null) {
            $driver = \App\Config\Database::DB_DRIVER;
            $dsn = self::createDSN($driver);

            if (!$dsn) {
                throw new Exception("Database driver '$driver' is not supported.");
            }

            try {
                self::$DB = new PDO($dsn, \App\Config\Database::DB_USER, \App\Config\Database::DB_PASSWORD, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (PDOException $e) {
                throw new Exception("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$DB;
    }

    /**
     * Create the DSN string based on the database driver and configuration.
     *
     * @param string $driver
     * @return string|null DSN string or null if the driver is unsupported
     */
    private static function createDSN(string $driver): ?string {
        $host = \App\Config\Database::DB_HOST;
        $dbname = \App\Config\Database::DB_NAME;
        $filepath = \App\Config\Database::DB_FILEPATH;
        $charset = 'utf8';

        return match ($driver) {
            'cubrid' => "cubrid:host=$host;dbname=$dbname;charset=$charset",
            'mssql' => "sqlsrv:Server=$host;Database=$dbname;charset=$charset",
            'informix' => "informix:host=$host;dbname=$dbname;charset=$charset",
            'oracle' => "oci:dbname=//$host/$dbname;charset=$charset",
            'mysql' => "mysql:host=$host;dbname=$dbname;charset=$charset",
            'postgresql' => "pgsql:host=$host;dbname=$dbname",
            'sqlite' => "sqlite:$filepath",
            default => null
        };
    }
}
