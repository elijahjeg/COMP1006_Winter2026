<?php
$pageTitle = "Player Confirmation";
require "includes/header.php";

// Sanitize and trim the form data
$firstName = trim(filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_SPECIAL_CHARS));
$lastName  = trim(filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_SPECIAL_CHARS));
$email     = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$phone     = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS));
$position  = trim(filter_input(INPUT_POST, 'pos', FILTER_SANITIZE_SPECIAL_CHARS));
$team      = trim(filter_input(INPUT_POST, 'team', FILTER_SANITIZE_SPECIAL_CHARS));

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
if ($team === null || $team === '') {
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


// If there are any errors let the user know and stop the script before doing anything else
if (!empty($errors)) {
    require "includes/header.php";?>
    <div class='alert alert-danger'>
        <h2>Please fix the following errors:</h2>
        <ul>
            <?php foreach ($errors as $error): ?>
                <!-- Prevent any unexpected HTML from being rendered by escaping special characters -->
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php
    echo "</ul>";
    echo "</div>";

    require "includes/footer.php";
    exit;
}

require "includes/connect.php";

$sql = "INSERT INTO players (first_name, last_name, email, phone, position, team_name) 
             VALUES (:first_name, :last_name, :email, :phone, :position, :team_name)"; // SQL statement with named placeholders

$stmt = $pdo->prepare($sql); // Prepare the statement with pdo->prepare()

// Bind the form data to the named placeholders in the SQL statement
$stmt->bindParam(":first_name", $firstName);
$stmt->bindParam(":last_name", $lastName);
$stmt->bindParam(":email", $email);
$stmt->bindParam(":phone", $phone);
$stmt->bindParam(":position", $position);
$stmt->bindParam(":team_name", $team);

$stmt->execute(); // Execute the statement

$pdo = null; // Close the database connection

// Initialize an array to hold the form data labels and corresponding input names
$userInfo = [
    "First Name" => $firstName,
    "Last Name" => $lastName,
    "Position" => $position,
    "Phone Number" => $phone,
    "Email" => $email,
    "Team Name" => $team,
];
?>

<div class='alert alert-success'>
    <h2>Player Information</h2>
    <p>Here is the information you submitted:</p>
    <ul class='list-group'>
        <?php foreach ($userInfo as $name => $item): ?>

    <li class='list-group-item'><strong><?=$name?>:</strong> <?= $item ?></li>

<?php endforeach;
echo "</ul>";

require "includes/footer.php";