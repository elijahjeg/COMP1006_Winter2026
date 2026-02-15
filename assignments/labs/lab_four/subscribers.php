<?php
require "includes/header.php";
require "includes/connect.php";

/*
  TODO:
  1. Write a SELECT query to get all subscribers
  2. Add ORDER BY subscribed_at DESC
  3. Prepare the statement
  4. Execute the statement
  5. Fetch all results into $subscribers
*/

$stmt = $pdo->prepare("SELECT * FROM subscribers ORDER BY subscribed_at DESC");

$stmt -> execute();

$subscribers = $stmt->fetchAll();

$pdo = null; // Close the database connection
?>

<main class="container mt-4">
  <h1>Subscribers</h1>

  <?php if (count($subscribers) === 0): ?>
    <p>No subscribers yet.</p>
  <?php else: ?>
    <table class="table table-bordered mt-3">
      <thead>
        <tr>
          <th>ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Subscribed</th>
        </tr>
      </thead>
      <tbody>
        <!-- TODO: Loop through $subscribers and output each row -->
         <?php foreach ($subscribers as $sub): ?>
          <tr>
              <th><?= $sub['id'] ?></th>
              <th><?= $sub['first_name'] ?></th>
              <th><?= $sub['last_name'] ?></th>
              <th><?= $sub['email'] ?></th>
              <th><?= $sub['subscribed_at'] ?></th>
         </tr>
         <?php endforeach?>
      </tbody>
    </table>
  <?php endif; ?>

  <p class="mt-3">
    <a href="index.php">Back to Subscribe Form</a>
  </p>
</main>
