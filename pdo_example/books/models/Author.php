<?php

class Author {
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // CREATE
    public function create(string $firstName, ?string $middleName, string $lastName): ?int
    {
        try {
            $stm = $this->pdo->prepare("INSERT INTO authors (first_name, middle_name, last_name) VALUES (:first, :middle, :last)");
            if ($stm->execute([':first' => $firstName, ':middle' => $middleName, ':last' => $lastName])) {
                return (int)$this->pdo->lastInsertId(); 
            }
        } catch (PDOException $e) {
            
            error_log("Error creating author: " . $e->getMessage());
            return null; 
        }
        return null; 
    }

    // READ 
    public function getAll(): array
    {
        try {
            $stm = $this->pdo->query("SELECT * FROM authors");
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching authors: " . $e->getMessage());
            return []; 
        }
    }

    // READ (Single)
    public function getById(int $id): ?array
    {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM authors WHERE author_id = :id");
            $stm->execute([':id' => $id]);
            return $stm->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching author by ID: " . $e->getMessage());
            return null; // Return null on failure
        }
    }

    // UPDATE
    public function update(int $id, string $firstName, ?string $middleName, string $lastName): bool
    {
        try {
            $stm = $this->pdo->prepare("UPDATE authors SET first_name = :first, middle_name = :middle, last_name = :last WHERE author_id = :id");
            return $stm->execute([':first' => $firstName, ':middle' => $middleName, ':last' => $lastName, ':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error updating author: " . $e->getMessage());
            return false; 
        }
    }

    // DELETE
    public function delete(int $id): bool
    {
        try {
            $stm = $this->pdo->prepare("DELETE FROM authors WHERE author_id = :id");
            return $stm->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error deleting author: " . $e->getMessage());
            return false; 
        }
    }
}