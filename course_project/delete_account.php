<?php
// Start or resume session and include necessary files
session_start();
require "includes/auth.php";
require "includes/connect.php";

// Check if the user is logged in
requireLogin("delete_account.php"); // Redirect to login page if not logged in

// Get the user's ID from the session
$userId = $_SESSION['user_id'];

// Delete the user's account from the database
$sql = "DELETE FROM users WHERE id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $userId);
$stmt->execute();

// Log the user out and redirect to the homepage
session_destroy();
header("Location: index.php");
exit;