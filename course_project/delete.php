<?php
require "includes/connect.php";
require "includes/auth.php";


// Check if an ID was provided in the URL (e.g., delete.php?id=5)
if (!isset($_GET['id'])) {
    die("No player ID provided.");
}

requireLogin("delete.php?id=" . $_GET['id']); // Redirect to login page if not logged in

$playerId = $_GET['id'];

// Create the DELETE query
$sql = "DELETE FROM players WHERE id = :id AND user_id = :user_id"; // Ensure that the player belongs to the logged-in user
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id", $playerId);
$stmt->bindParam(":user_id", $_SESSION['user_id']);
$stmt->execute();

$pdo = null; // Close the database connection

// Redirect back to the players page after successful deletion
header("Location: players.php");
exit;