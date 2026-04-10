<?php
$host = "172.31.22.43"; // Hostname
$db = "Elijah200653466"; // Database name
$user = "Elijah200653466"; // Username
$password = "mZYUTfy1Z-"; // Password

// This points to the database
$dsn = "mysql:host=$host;dbname=$db";

// Attempt to connect
try {
   $pdo = new PDO ($dsn, $user, $password); // Initialize a new PDO object
   $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); // Make sure an exception is thrown if connection fails
}
// If connection fails, catch the exception and echo the error message 
catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage()); 
}
