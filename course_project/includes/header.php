<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Team Tracker | <?= $pageTitle ?></title>
        <link href="styles/main.css" rel="stylesheet">
        <!--add bootstrap css -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <!-- add bootstrap js -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
        <link href="styles/main.css" rel="stylesheet">
    </head>
    <body>
        <header>
            <!-- Use Bootstrap's navbar component for the header -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="index.php">Team Tracker</a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <!-- Use the $pageTitle variable to set the active class on the current page's link -->
                            <a class="nav-link <?= ($pageTitle === 'Create a New Player') ? 'active' : '' ?>" href="index.php">Create a New Player</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($pageTitle === 'View All Players') ? 'active' : '' ?>" href="players.php">View All Players</a>
                        </li>
                    </ul>
                <?php
                    // Check if the user is logged in by checking if the username is set in the session
                    require "includes/auth.php";
                    if (isLoggedIn()): ?>
                        <div class="ms-auto d-flex align-items-center">
                            <span class="navbar-text me-4">Welcome, <?= htmlspecialchars($_SESSION['username']); ?>!</span>
                            <div class="nav-item dropdown-center">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    My Account
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="settings.php">Settings</a></li>
                                    <li class="red"><a class="dropdown-item" href="logout.php">Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="ms-auto">
                            <a href="register.php" class="btn btn-sm btn-outline-primary <?= ($pageTitle === 'Sign Up') ? 'active' : '' ?>">Sign Up</a>
                            <a href="login.php" class="btn btn-sm btn-outline-secondary <?= ($pageTitle === 'Login') ? 'active' : '' ?>">Login</a>
                        </div>
                    <?php endif; ?>

                </div>
            </nav>
        </header>
