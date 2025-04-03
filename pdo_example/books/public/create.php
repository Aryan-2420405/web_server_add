<?php
require_once '../../config/db_config.php';
require_once '../../config/DBConnection.php';
require_once '../models/Book.php';

try {
    $pdo = DBConnection::connect($host, $user, $dbName, $password);
    $bookModel = new Book($pdo);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name']); 
        $isbn = trim($_POST['isbn']); 

        if (!empty($name) && !empty($isbn)) {
            $bookId = $bookModel->create($name, $isbn); 
            if ($bookId) {
                header('Location: index.php'); 
                exit;
            } else {
                $error = "Failed to add the book. Please try again.";
            }
        } else {
            $error = "Please fill in all fields.";
        }
    }
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Add New Book</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="name" class="form-label">Book Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="isbn" class="form-label">ISBN</label>
            <input type="text" class="form-control" id="isbn" name="isbn" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Book</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>