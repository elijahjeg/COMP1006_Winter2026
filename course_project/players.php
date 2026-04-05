<?php
$pageTitle = "View All Players";

require "includes/header.php";
require "includes/connect.php";

// Get all players in the database and display them in a table
$sql = "SELECT * FROM players ORDER BY id";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$players = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pdo = null; // Close the database connection

?>

<main class="container mt-4">
    <h2>Players</h2>

    <?php if (empty($players)): // No players found ?>
        <p>No players yet.</p>
    <?php else: ?>
        <!-- Display players in a table -->
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Photo</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Position</th>
                    <th>Team Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($players as $player): ?>
                    <tr>
                        <!-- Escape all output to prevent any unexpected HTML from being rendered -->
                        <td><?= htmlspecialchars($player['id']) ?></td>
                        <td>
                            <?php if ($player['image_path']):?>
                            <img src="<?= htmlspecialchars($player['image_path'])?>" alt="<?= htmlspecialchars($player['first_name'])?>">
                            <?php else:?>
                            No photo provided
                            <?php endif ?>
                        </td>
                        <td><?= htmlspecialchars($player['last_name']) ?></td>
                        <td><?= htmlspecialchars($player['email']) ?></td>
                        <td><?= htmlspecialchars($player['phone']) ?></td>
                        <td><?= htmlspecialchars($player['position']) ?></td>
                        <td><?= htmlspecialchars($player['team_name']) ?></td>

                        <!-- Add an Update button that links to the update page with the player's ID as a query parameter -->
                        <td class="d-flex justify-content-center gap-4"> <!-- Make the buttons flex items -->
                            <button class="btn btn-sm btn-warning">
                                <a href="update.php?id=<?= htmlspecialchars($player['id']) ?>" class="text-white">Update</a>
                            </button>
                            <button class="btn btn-sm btn-danger">
                                <a 
                                    href="delete.php?id=<?= htmlspecialchars($player['id']) ?>" 
                                    class="text-white"
                                    onclick="return confirm('Are you sure you want to delete this player?');">
                                    Delete
                                </a>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <!-- Link back to the form to add another player -->
    <button class="mt-3 btn btn-primary">
        <!-- If there are no players, say "Add a Player". If there are already players, say "Add Another Player" -->
        <a href="index.php" class="text-white">Add <?= empty($players) ? "a" : "Another" ?> Player</a>
    </button>
</main>

<?php
require "includes/footer.php";