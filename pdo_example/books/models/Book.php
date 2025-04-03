<?php

class Book {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // CREATE
    public function create(string $name, string $isbn): ?int {
        try {
            $stm = $this->pdo->prepare("INSERT INTO books (name, isbn) VALUES (:name, :isbn)");
            if ($stm->execute([':name' => $name, ':isbn' => $isbn])) {
                return (int)$this->pdo->lastInsertId(); 
            }
        } catch (PDOException $e) {
            error_log("Error creating book: " . $e->getMessage());
            return null; 
        }
        return null;
    }

    // READ (All)
    public function getAll(): array {
        try {
            $stm = $this->pdo->query("SELECT * FROM books");
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching books: " . $e->getMessage());
            return []; 
        }
    }

    // READ (Single)
    public function getById(int $id): ?array {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM books WHERE book_id = :id");
            $stm->execute([':id' => $id]);
            return $stm->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching book by ID: " . $e->getMessage());
            return null; 
        }
    }

    // UPDATE
    public function update(int $id, string $name, string $isbn): bool {
        try {
            $stm = $this->pdo->prepare("UPDATE books SET name = :name, isbn = :isbn WHERE book_id = :id");
            return $stm->execute([':name' => $name, ':isbn' => $isbn, ':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error updating book: " . $e->getMessage());
            return false; 
        }
    }

    // DELETE
    public function delete(int $id): bool {
        try {
            $stm = $this->pdo->prepare("DELETE FROM books WHERE book_id = :id");
            return $stm->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error deleting book: " . $e->getMessage());
            return false;
        }
    }
}