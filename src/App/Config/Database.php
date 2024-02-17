<?php

namespace App\Config;

use Core\Config;

class Database extends Config {

	/**
	 * Is database turned on
	 */
	const USE_DATABASE = false;

	/**
	 * Database Driver
	 * @var string
	 * */
	const DB_DRIVER = 'mysql';

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'localhost';
    
    /**
     * Database name
     * @var string
     */
    const DB_NAME = '';
    
    /**
     * Database user
     * @var string
     */
    const DB_USER = '';
    
    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = '';

    /**
     * Database Filepath for SQLite
     * @var string
     */
    const DB_FILEPATH = '';
}