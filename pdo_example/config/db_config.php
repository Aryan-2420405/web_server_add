<?php
$host = "localhost"; // IP: 127.0.0.1
$dbName = 'book_db';
$user = 'root';
$password = '';

try {
    // Create connection
    $conn = new mysqli($host, $user, $password, $dbName);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";

    // Your database operations go here

} catch (Exception $e) {
    // Handle connection error
    die($e->getMessage());
} finally {
    // Close connection if it was established
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }
}
?>