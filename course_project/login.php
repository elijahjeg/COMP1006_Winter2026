<?php
// Start or resume session and include necessary files
session_start();
require "includes/connect.php";
$pageTitle = "Login";
require "includes/header.php";

$error = "";
$redirect = $_GET['redirect'];

$secretKey = "6Lcu9bEsAAAAAKAq-fkxJmHatr1B8TYTZEObZEy7";
try {
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and trim the username/email and password from the form
    $usernameOrEmail = trim($_POST['username_or_email'] ?? '');
    $password = $_POST['password'] ?? '';
    $recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';

    // Verify the reCAPTCHA response with Google's API
    $recaptchaUrl = "https://www.google.com/recaptcha/api/siteverify";
    $recaptchaData = [
        'secret' => $secretKey,
        'response' => $recaptchaResponse
    ];
    // Use stream context to send a POST request to the reCAPTCHA API
    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($recaptchaData)
        ]
    ];

    // Create a stream context and send the request to the reCAPTCHA API
    $context = stream_context_create($options);
    $recaptchaResult = file_get_contents($recaptchaUrl, false, $context);
    $recaptchaResultData = json_decode($recaptchaResult, true);

    // Check if the reCAPTCHA verification was successful
    if (!$recaptchaResultData['success']) {
        $error = "reCAPTCHA verification failed. Please try again.";
     } 
     else {
         // Proceed with login logic if reCAPTCHA is successful

        // Validate that both fields are filled in
        if ($usernameOrEmail === '' || $password === '') {
            $error = "Username/email and password are required.";
        } else {
            // Prepare and execute a SQL statement to find a user with the given username or email
            $sql = "SELECT id, username, email, password
                    FROM users
                    WHERE username = :login OR email = :login
                    LIMIT 1";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':login', $usernameOrEmail);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                header("Location: $redirect");
                exit;
            } else {
                $error = "Invalid credentials. Please try again.";
            }
        }
    }
}
}
catch (PDOException $e) {
    // Handle any database errors gracefully
    $error = "An error occurred while processing your login. Please try again later.";
    // Log the actual error message for debugging purposes (not shown to the user)
    echo("Database error: " . $e->getMessage());
}
?>
 <script src="https://www.google.com/recaptcha/api.js"></script>
 <script>
   function onSubmit(token) {
     document.getElementById("demo-form").submit();
   }
 </script>

<main class="container mt-4">
    <?php if (isset($redirect)): ?>
        <div class="alert alert-info">
            Please log in to access the requested page.
        </div>
    <?php endif; ?>
    <h2>Login</h2>

    <?php if ($error !== ""): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form method="post" class="mt-3">
        <label for="username_or_email" class="form-label">Username or Email</label>
        <input
            type="text"
            id="username_or_email"
            name="username_or_email"
            class="form-control mb-3"
            required
        >

        <label for="password" class="form-label">Password</label>
        <input
            type="password"
            id="password"
            name="password"
            class="form-control mb-4"
            required
        >
        <div class="container mb-4">
            <button class="g-recaptcha btn btn-primary" 
            data-sitekey="6Lcu9bEsAAAAAHWIeMSi7SNZNmohSBdpvjmGOSNn" 
            data-callback='onSubmit' 
            data-action='submit'>Submit reCAPTCHA</button>
        </div>

        <div>
            <button type="submit" class="btn btn-primary">Login</button>
            <a href="register.php" class="btn btn-secondary">Create Account</a>
        </div>
    </form>
</main>

<?php require "includes/footer.php"; ?>