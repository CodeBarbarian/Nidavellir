<?php

namespace Core\Forge\Middleware\Database;

use PDO;

abstract class Database extends PDO {
    protected static function getDB(): ?PDO {
        if (\App\Config\Database::USE_DATABASE){
            static $DB = null;

            if ($DB == NULL) {
                
                switch (\App\Config\Database::DB_DRIVER){
                    case 'cubrid':
                        $DSN = sprintf("cubrid:host=%s;dbname=%s;charset=utf8", \App\Config\Database::DB_HOST, \App\Config\Database::DB_NAME);
                        $DB = new PDO($DSN, \App\Config\Database::DB_USER, \App\Config\Database::DB_PASSWORD);
                        break;

                    case 'mssql':
                        $DSN = sprintf("mssql:host=%s;dbname=%s;charset=utf8", \App\Config\Database::DB_HOST, \App\Config\Database::DB_NAME);
                        $DB = new PDO($DSN, \App\Config\Database::DB_USER, \App\Config\Database::DB_PASSWORD);
                        break;
                    
                    case 'firebird':
                        // @TODO: Implement system for Firebird DB
                        break;

                    case 'ibm':
                        // @TODO: Implement system for IBM DB
                        break;

                    case 'informix':
                        $DSN = sprintf("informix:host=%s;dbname=%s;charset=utf8", \App\Config\Database::DB_HOST, \App\Config\Database::DB_NAME);
                        $DB = new PDO($DSN, \App\Config\Database::DB_USER, \App\Config\Database::DB_PASSWORD);
                        break;
                    
                    case 'oracle':
                        $DSN = sprintf("oci:host=%s;dbname=%s;charset=utf8", \App\Config\Database::DB_HOST, \App\Config\Database::DB_NAME);
                        $DB = new PDO($DSN, \App\Config\Database::DB_USER, \App\Config\Database::DB_PASSWORD);
                        break;

                    case 'mysql':
                        $DSN = sprintf("mysql:host=%s;dbname=%s;charset=utf8", \App\Config\Database::DB_HOST, \App\Config\Database::DB_NAME);
                        $DB = new PDO($DSN, \App\Config\Database::DB_USER, \App\Config\Database::DB_PASSWORD);
                        break;

                    case 'odbc':
						// @TODO: Implement system for ODBC DB
                        break;
                    
                    case 'postgresql':
                        $DSN = sprintf("pgsql:host=%s;dbname=%s;charset=utf8", \App\Config\Database::DB_HOST, \App\Config\Database::DB_NAME);
                        $DB = new PDO($DSN, \App\Config\Database::DB_USER, \App\Config\Database::DB_PASSWORD);
                        break;

                    case 'sqlite':
                        $DB = new PDO("sqlite:host=%s;charset=utf8", \App\Config\Database::DB_FILEPATH);
                        break;
                }
            }

            return $DB;
            
        }

        return false;
    }
}