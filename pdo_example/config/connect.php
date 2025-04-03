<?php

function connect($dbHost, $dbUser , $databaseName, $dbPassword) {
    try {
        $dsn = "mysql:host=$dbHost;dbname=$databaseName;charset=utf8"; // Use 'charset=utf8' instead of 'charSet=UTF8'
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Set default fetch mode
            PDO::ATTR_EMULATE_PREPARES => false, // Disable emulation of prepared statements
        ];

        $pdo = new PDO($dsn, $dbUser , $dbPassword, $options);
        return $pdo; // Return the PDO instance for further use
    } catch (PDOException $e) {
        // Handle connection error
        die("Database connection failed: " . $e->getMessage()); // Use die() to stop execution on error
    }
}

?>