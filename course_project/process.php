<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request');
}

$pageTitle = "Player Confirmation";
require "includes/header.php";

requireLogin("index.php"); // Redirect to login page if not logged in

require "includes/validation.php"; // Sanitize and validate the form data


$image = $_FILES['image'];
if (isset($image) && $image['error'] !== UPLOAD_ERR_NO_FILE){
    // Make sure the image was uploaded successfully
    if ($image['error'] !== UPLOAD_ERR_OK){
        $errors[] = 'Error uploading image';
    }
    else {
        // Array to hold allowed file types
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];

        // Detect the file type of the image
        $detectedType = mime_content_type($image['tmp_name']);

        // Check if the detected file type is an allowed type
        if (!in_array($detectedType, $allowedTypes, true)) {
            $errors[] = 'Invalid image type. The allowed image types are: JP(E)G, PNG, AND WEBP';
        }

        // Limit the file size to 2 MB
        elseif ($image['size'] > 2 * 1024 * 1024){
            $errors[] = 'Max image size of 2MB exceeded.';
        }

        else {
            // Grab the extension of the image
            $extension = pathinfo($image['name'], PATHINFO_EXTENSION);

            // Make a unique filename to privent file overwrites
            $safeFilename = uniqid('player_', true) . '.' . strtolower($extension);

            // Get the full path that the file will be stored
            $destination = __DIR__ . '/uploads/' . $safeFilename;

            if (move_uploaded_file($image['tmp_name'], $destination)){
                // Get the relative path so we can display it to the user.
                $imagePath = 'uploads/' . $safeFilename;
            }
            else {
                $errors[] = 'Failed to move the uploaded image.';
            }
        }
    }
}

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

$sql = "INSERT INTO players (first_name, last_name, email, phone, position, team_name, image_path, user_id) 
             VALUES (:first_name, :last_name, :email, :phone, :position, :team_name, :image_path, :user_id)"; // SQL statement with named placeholders

$stmt = $pdo->prepare($sql); // Prepare the statement with pdo->prepare()

// Bind the form data to the named placeholders in the SQL statement
$stmt->bindParam(":first_name", $firstName);
$stmt->bindParam(":last_name", $lastName);
$stmt->bindParam(":email", $email);
$stmt->bindParam(":phone", $phone);
$stmt->bindParam(":position", $position);
$stmt->bindParam(":team_name", $team_name);
$stmt->bindParam(":image_path", $imagePath); // Assuming $imagePath holds the path to the uploaded image, or null if no image was uploaded
$stmt->bindParam(":user_id", $_SESSION['user_id']); // Bind the user ID from the session to associate the player with the logged-in user

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
    "Player Photo" => isset($imagePath) ? "<img src='$imagePath' alt='Player Image'>" : "No image uploaded"
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