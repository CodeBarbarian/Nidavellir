<?php

namespace App\Config;

use Core\Config;

class Database extends Config {

	/**
	 * Is database turned on
	 */
	const bool USE_DATABASE = false;

	/**
	 * Database Driver
	 * @var string
	 * */
	const string DB_DRIVER = 'mysql';

    /**
     * Database host
     * @var string
     */
    const string DB_HOST = 'localhost';
    
    /**
     * Database name
     * @var string
     */
    const string DB_NAME = '';
    
    /**
     * Database user
     * @var string
     */
    const string DB_USER = '';
    
    /**
     * Database password
     * @var string
     */
    const string DB_PASSWORD = '';

    /**
     * Database Filepath for SQLite
     * @var string
     */
    const string DB_FILEPATH = '';
}