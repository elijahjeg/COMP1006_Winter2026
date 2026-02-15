<?php
require "includes/header.php";
//  TODO: connect to the database 
require "includes/connect.php";
//   TODO: Grab form data (no validation or sanitization for this lab)
$first_name = $_POST['first_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';
$email = $_POST['email'] ?? '';

/*
  1. Write an INSERT statement with named placeholders
  2. Prepare the statement
  3. Execute the statement with an array of values
  4.

*/

$sql = "INSERT INTO subscribers (first_name, last_name, email) 
             VALUES (:first_name, :last_name, :email)"; // SQL statement with named placeholders

$stmt = $pdo->prepare($sql); // Prepare the statement with pdo->prepare()

// Bind the form data to the named placeholders in the SQL statement
$stmt->bindParam(":first_name", $first_name);
$stmt->bindParam(":last_name", $last_name);
$stmt->bindParam(":email", $email);

$stmt->execute(); // Execute the statement

$pdo = null; // Close the database connection
?>

<body>

    <main class="container mt-4">
        <h2>Thank You for Subscribing</h2>

        <!-- TODO: Display a confirmation message -->
        <!-- Example: "Thanks, Name! You have been added to our mailing list." -->


        <p class="mt-3">
            <a href="subscribers.php">View Subscribers</a>
        </p>
        <p>
            <?php
                echo("Thanks, {$first_name}, you've been added to our mailing list!")
            ?>
        </p>
    </main>
</body>

</html>