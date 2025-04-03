<?php

require_once 'config/db_config.php';
require_once 'config/DBConnection.php';
require_once 'Book.php';
require_once 'Author.php';

try {
    $pdo = DBConnection::connect($host, $user, $dbName, $password);
    $book = new Book($pdo);
    $author = new Author($pdo);

    // CREATE Book
    $newBookId = $book->create("New Book", "123-456");
    if ($newBookId) {
        echo "New book created with ID: $newBookId\n";
    } else {
        echo "Failed to create book.\n";
    }

    // READ Books
    $books = $book->getAll();
    echo "Books:\n";
    print_r($books);

    // UPDATE Book
    if ($book->update(1, "Updated Book Name", "999-888")) {
        echo "Book updated successfully.\n";
    } else {
        echo "Failed to update book.\n";
    }

    // DELETE Book
    if ($book->delete(1)) {
        echo "Book deleted successfully.\n";
    } else {
        echo "Failed to delete book.\n";
    }

    // CREATE Author
    $newAuthorId = $author->create("John", "Doe", "Smith");
    if ($newAuthorId) {
        echo "New author created with ID: $newAuthorId\n";
    } else {
        echo "Failed to create author.\n";
    }

    // READ Authors
    $authors = $author->getAll();
    echo "Authors:\n";
    print_r($authors);

    // UPDATE Author
    if ($author->update(1, "Updated John", null, "Smithson")) {
        echo "Author updated successfully.\n";
    } else {
        echo "Failed to update author.\n";
    }

    // DELETE Author
    if ($author->delete(1)) {
        echo "Author deleted successfully.\n";
    } else {
        echo "Failed to delete author.\n";
    }

} catch (PDOException $e) {
    // Handle connection error
    die("Database connection failed: " . $e->getMessage());
}