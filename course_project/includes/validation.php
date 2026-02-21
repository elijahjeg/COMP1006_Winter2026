<?php
// This file is included in index.php and update.php to handle validation of form data

// Sanitize and trim the form data
$firstName = trim(filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS));
$lastName  = trim(filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS));
$email     = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$phone     = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS));
$position  = trim(filter_input(INPUT_POST, 'position', FILTER_SANITIZE_SPECIAL_CHARS));
$team_name      = trim(filter_input(INPUT_POST, 'team_name', FILTER_SANITIZE_SPECIAL_CHARS));

// Server-side validation
$errors = [];

// Required fields
if ($firstName === null || $firstName === '') {
    $errors[] = "First Name is required.";
}

if ($lastName === null || $lastName === '') {
    $errors[] = "Last Name is required.";
}

// Position is required
if ($position === null || $position === '') {
    $errors[] = "Position is required.";
}

// Team is required
if ($team_name === null || $team_name === '') {
    $errors[] = "Team Name is required.";
}


// Make sure email is provided and valid format
if ($email === null || $email === '') {
    $errors[] = "Email is required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Email must be a valid email address.";
}

// Make sure phone is provided and matches a simple regex pattern (digits, spaces, dashes, parentheses, plus)
if ($phone === null || $phone === '') {
    $errors[] = "Phone number is required.";
} elseif (!filter_var($phone, FILTER_VALIDATE_REGEXP, [
    'options' => ['regexp' => '/^[0-9\-\+\(\)\s]{7,25}$/']
])) {
    $errors[] = "Phone number format is invalid.";
}