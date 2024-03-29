<?php

namespace AndreiCroitoru\FrameworkPhp;

use PDO;

abstract class Database
{
    protected PDO $conn;

    public function __construct()
    {
        try {
            $options = [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING];

            if (DB_TYPE === 'pgsql') {
                $databaseEncoding = " options='--client_encoding=" . DB_CHARSET . "'";
            } else {
                $databaseEncoding = '; charset=' . DB_CHARSET;
            }

            $this->conn = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . $databaseEncoding, DB_USER, DB_PASS, $options);
        } catch (\PDOException $e) {
            exit('Database connection could not be established.');
        }
    }
}
