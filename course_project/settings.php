<?php
$pageTitle = 'Settings';
require "includes/header.php";
requireLogin("settings.php"); // Redirect to login page if not logged in

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission to update user settings
    require "includes/connect.php";

    // Retrieve and sanitize the username from the form
    $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS));

    // Retrieve and sanitize the email from the form
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));

    // Retrieve and sanitize the password from the form
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Validate the new username and password
    if (empty($username) && empty($password) && empty($email)) {
        $errors[] = "All fields cannot be empty.";
    } 

    // Validate the form inputs
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email must be a valid email address.";
    }


    if (!empty($password)) {
        // Check that the password meets a minimum length requirement (e.g., at least 8 characters)
        if (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long.";
        }
        if ($confirmPassword === '') {
            $errors[] = "Please confirm your password.";
        }
        // Check that both password fields match
        elseif ($password !== $confirmPassword) {
            $errors[] = "Passwords do not match.";
        }
    }


    // Check for any validation errors before proceeding with database operations
    if (empty($errors)) {
        $query = [];

        if (!empty($username)) {
            $query[] = "username = :username";
        }

        if (!empty($email)) {
            $query[] = "email = :email";
        }

        if (!empty($password)) {
            $query[] = "password = :password";
        }


        // Check if the username or email is already taken
        $sql = "SELECT id FROM users WHERE username = :username OR email = :email";
        
        $stmt = $pdo->prepare($sql);

        
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);

        
        $stmt->execute();

        // If a record is found, it means the username or email is already in use
        if ($stmt->fetch()) {
            $errors[] = "That username or email is already in use.";
        }

        // Update the user's username and password in the database
        $sql = "UPDATE users SET " . implode(", ", $query) . " WHERE id = :user_id";
        $stmt = $pdo->prepare($sql);
        if (!empty($username)) {
            $stmt->bindParam(':username', $username);
        }
        if (!empty($email)) {
            $stmt->bindParam(':email', $email);
        }
        if (!empty($password)) {
            $stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT)); // Hash the password before storing
        }
        $stmt->bindParam(':user_id', $_SESSION['user_id']);
        $stmt->execute();

        // Update the username in the session if it was changed
        if (!empty($username)) {
            $_SESSION['username'] = $username;
        }

        echo "<div class='alert alert-success'>Settings updated successfully.</div>";
    }
    else {
        // Display the errors to the user
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }
    $pdo = null; // Close the database connection
}
?>
<main class="container mt-4">
    <h2>Settings</h2>
    <p>
        Use the form below to update your account settings. You can change your username, email, and password.
        <br />Leave any fields you do not wish to change blank.
    </p>

    <form method="post" class="mt-3">
        <label for="username" class="form-label">New Username</label>
        <input
            type="text"
            id="username"
            name="username"
            class="form-control mb-3"
            value="<?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?>"
        >

        <label for="email" class="form-label">New Email</label>
        <input
            type="email"
            id="email"
            name="email"
            class="form-control mb-3"
        >

        <label for="password" class="form-label">New Password</label>
        <input
            type="password"
            id="password"
            name="password"
            class="form-control mb-3"
        >

        <label for="confirm_password" class="form-label">Confirm New Password</label>
        <input
            type="password"
            id="confirm_password"
            name="confirm_password"
            class="form-control mb-4"
        >

        <button type="submit" class="btn btn-primary">Update Settings</button>
        <a href="delete_account.php" class="btn btn-danger">Delete Account</a>
    </form>
</main>
