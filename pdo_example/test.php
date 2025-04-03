<?php

require_once('config/db_config.php');
require_once('config/DBConnection.php');

// Step 1: Connect to MySQL server
$pdoObject = DBConnection::connect($host, $user, $dbName, $password);

// Step 2: Create the database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS `$dbName`";
$pdoObject->exec($sql);
echo "Database '$dbName' created or already exists.<br>";

// Step 3: Switch to the new database
$pdoObject->exec("USE `$dbName`");

// Drop tables if they exist to avoid conflicts
$pdoObject->exec("DROP TABLE IF EXISTS book_authors");
$pdoObject->exec("DROP TABLE IF EXISTS books");
$pdoObject->exec("DROP TABLE IF EXISTS authors");

// Step 4: SQL statement for creation of tables
$tablesSql = [
    "books" => 'CREATE TABLE IF NOT EXISTS books( 
        book_id   INT AUTO_INCREMENT,
        name  VARCHAR(100) NOT NULL, 
        isbn  VARCHAR(50) NOT NULL,
        PRIMARY KEY(book_id));',
    "authors" => 'CREATE TABLE IF NOT EXISTS authors( 
        author_id   INT AUTO_INCREMENT,
        first_name  VARCHAR(100) NOT NULL, 
        middle_name VARCHAR(50) NULL, 
        last_name   VARCHAR(100) NULL,
        PRIMARY KEY(author_id));',
    "book_authors" => 'CREATE TABLE IF NOT EXISTS book_authors (
        book_id   INT NOT NULL, 
        author_id INT NOT NULL, 
        PRIMARY KEY(book_id, author_id), 
        CONSTRAINT fk_book 
            FOREIGN KEY(book_id) 
            REFERENCES books(book_id) 
            ON DELETE CASCADE, 
        CONSTRAINT fk_author 
            FOREIGN KEY(author_id) 
            REFERENCES authors(author_id) 
            ON DELETE CASCADE
    );'
];

foreach ($tablesSql as $tableName => $sql) {
    try {
        $pdoObject->exec($sql);
        echo "Table `$tableName` created successfully. <br>";
    } catch (PDOException $e) {
        echo "Error creating table `$tableName`: " . htmlspecialchars($e->getMessage()) . "<br>";
    }
}