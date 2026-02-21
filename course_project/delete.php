<?php
require "includes/connect.php";

// Check if an ID was provided in the URL (e.g., delete.php?id=5)
if (!isset($_GET['id'])) {
    die("No player ID provided.");
}

$playerId = $_GET['id'];

// Create the DELETE query
$sql = "DELETE FROM players WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id", $playerId);
$stmt->execute();

$pdo = null; // Close the database connection

// Redirect back to the players page after successful deletion
header("Location: players.php");
exit;