<?php
// Required file to start the session
require "includes/auth.php";

// Clear all session variables by replacing the session array with an empty one
$_SESSION = [];

// Unset all session variables currently stored in memory
session_unset();

// Destroy the session completely on the server
session_destroy();

// Redirect the user back to the login page
header("Location: login.php");

exit;