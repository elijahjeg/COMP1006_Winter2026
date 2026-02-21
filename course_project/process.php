<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request');
}


require "includes/validation.php"; // Sanitize and validate the form data

$pageTitle = "Player Confirmation";
require "includes/header.php";

// If there are any errors let the user know and stop the script before doing anything else
if (!empty($errors)) { ?>
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
$stmt->bindParam(":team_name", $team_name);

$stmt->execute(); // Execute the statement

$pdo = null; // Close the database connection

// Initialize an array to hold the form data labels and corresponding input names
$userInfo = [
    "First Name" => htmlspecialchars($firstName),
    "Last Name" => htmlspecialchars($lastName),
    "Position" => htmlspecialchars($position),
    "Phone Number" => htmlspecialchars($phone),
    "Email" => htmlspecialchars($email),
    "Team Name" => htmlspecialchars($team_name),
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