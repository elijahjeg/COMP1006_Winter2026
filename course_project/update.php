<?php
$pageTitle = "Update Player Information";
require "includes/header.php";
require "includes/connect.php";

if (!isset($_GET['id'])){
    die("No player ID provided.");
}

$playerId = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the form submission to update the player's information in the database

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
                $safeFilename = uniqid('product_', true) . '.' . strtolower($extension);

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

    if (!empty($errors)) {
        // If there are validation errors, display them and stop the script
        echo "<div class='alert alert-danger'>";
        echo "<h2>Please fix the following:</h2>";
        echo "<ul class='list-group'>";
        foreach ($errors as $error) {
            echo "<li class='list-group-item'>" . htmlspecialchars($error) . "</li>";
        }
        echo "</ul>";
        echo "</div>";

        require "includes/footer.php";
        exit;
    }

    // Update the player's information in the database using a prepared statement
    $sql = "UPDATE players
            SET first_name = :first_name,
                last_name = :last_name,
                email = :email,
                phone = :phone,
                position = :position,
                team_name = :team_name,
                image_path = :image_path
            WHERE id = :id";
// Prepare the statement with pdo->prepare()
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":first_name", $firstName);
    $stmt->bindParam(":last_name", $lastName);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":phone", $phone);
    $stmt->bindParam(":position", $position);
    $stmt->bindParam(":team_name", $team_name);
    $stmt->bindParam(":image_path", $imagePath); // Bind the image path, or null if no new image was uploaded
    $stmt->bindParam(":id", $playerId);

    $stmt->execute();

    $pdo = null; // Close the database connection

    // Redirect back to the players page after successful update
    header("Location: players.php");
    exit;
}
?>



<main>
    <h2><?= $pageTitle ?></h2>
    <p>Use the form below to update a player's information. All fields are required.</p>

    <?php require "includes/connect.php"; // Fetch the existing player information to pre-fill the form
    $sql = "SELECT * FROM players WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $playerId);
    $stmt->execute();
    $player = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>

    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name:</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($player['first_name']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name:</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($player['last_name']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($player['email']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number:</label>
            <input type="tel" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($player['phone']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="position" class="form-label">Position:</label>
            <input type="text" class="form-control" id="position" name="position" value="<?= htmlspecialchars($player['position']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="team_name" class="form-label">Team Name:</label>
            <input type="text" class="form-control" id="team_name" name="team_name" value="<?= htmlspecialchars($player['team_name']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label" for="image">Add your player's photo to upload:</label>
            <input 
                type="file" 
                name="image" 
                id="image" 
                accept=".jpg,.jpeg,.png,.webp"
                class="form-control mb-4"
            />
        </div>

        <button type="submit" class="btn btn-primary">Update Player</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
    </form>
</main>

<?php
require "includes/footer.php";