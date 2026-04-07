<?php
// This file contains authentication-related functions

session_start();

// Prevent standard browser/proxy caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

function isLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}

function requireLogin(string $redirect): void {
    if (!isLoggedIn()) {
        header("Location: login.php?redirect=$redirect");
        exit;
    }
}
