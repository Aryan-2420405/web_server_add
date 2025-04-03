<?php

class DBConnection {
    public static function connect($dbHost, $dbUser , $databaseName, $dbPassword) {
        try {
            $dsn = "mysql:host=$dbHost;dbname=$databaseName;charset=utf8"; 
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
                PDO::ATTR_EMULATE_PREPARES => false, 
            ];
    
            return new PDO($dsn, $dbUser , $dbPassword, $options);
        } catch (PDOException $e) {
            die("Database Connection Failed: " . $e->getMessage());
        }
    }
}