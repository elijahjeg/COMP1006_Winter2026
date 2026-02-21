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
                team_name = :team_name
            WHERE id = :id";
// Prepare the statement with pdo->prepare()
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":first_name", $firstName);
    $stmt->bindParam(":last_name", $lastName);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":phone", $phone);
    $stmt->bindParam(":position", $position);
    $stmt->bindParam(":team_name", $team_name);
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

    <form method="post">
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

        <button type="submit" class="btn btn-primary">Update Player</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
    </form>
</main>

<?php
require "includes/footer.php";