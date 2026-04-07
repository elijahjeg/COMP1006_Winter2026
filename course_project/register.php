<?php
// Connect to the database and include the site header
require "includes/connect.php";
$pageTitle = "Sign Up";
require "includes/header.php";

// Initialize an array to store any validation errors that occur during form submission
$errors = [];

$success = "";

// Make sure the registration logic only runs when the form is submitted using POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    
    // Retrieve and sanitize the username from the form
    $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS));

    // Retrieve and sanitize the email from the form
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));

    // Retrieve and sanitize the password from the form
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Validate the form inputs
    if ($username === '') {
        $errors[] = "Username is required.";
    }

    
    if ($email === '') {
        $errors[] = "Email is required.";
    }
    
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email must be a valid email address.";
    }

    
    if ($password === '') {
        $errors[] = "Password is required.";
    }

    
    if ($confirmPassword === '') {
        $errors[] = "Please confirm your password.";
    }

    // Check that both password fields match
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    // Check that the password meets a minimum length requirement (e.g., at least 8 characters)
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }

    // Check for any validation errors before proceeding with database operations
    if (empty($errors)) {

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
    }

    
    if (empty($errors)) {

        // Hash the password securely using PHP's built-in password_hash function
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the SQL statement for inserting the new user
        $sql = "INSERT INTO users (username, email, password)
                VALUES (:username, :email, :password)";

        
        $stmt = $pdo->prepare($sql);

        
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        
        $stmt->execute();

        
        $success = "Account created successfully. You can now log in.";
    }
}
?>

<main class="container mt-4">
    <h2>Sign Up</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <h3>Please fix the following:</h3>
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($success !== ""): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($success); ?>
            <br>
            <a href="login.php" class="btn btn-sm btn-success mt-2">Go to Login</a>
        </div>
    <?php endif; ?>

    <form method="post" class="mt-3">

        <label for="username" class="form-label">Username</label>
        <input
            type="text"
            id="username"
            name="username"
            class="form-control mb-3"
            value="<?= htmlspecialchars($username ?? ''); ?>"
            required
        >

        <label for="email" class="form-label">Email</label>
        <input
            type="email"
            id="email"
            name="email"
            class="form-control mb-3"
            value="<?= htmlspecialchars($email ?? ''); ?>"
            required
        >

        <label for="password" class="form-label">Password</label>
        <input
            type="password"
            id="password"
            name="password"
            class="form-control mb-3"
            required
        >

        <label for="confirm_password" class="form-label">Confirm Password</label>
        <input
            type="password"
            id="confirm_password"
            name="confirm_password"
            class="form-control mb-4"
            required
        >

        <button type="submit" class="btn btn-primary">Create Account</button>

        <a href="login.php" class="btn btn-secondary">Login Instead</a>
    </form>
</main>

<?php

require "includes/footer.php";
?>