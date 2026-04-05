<?php
    // This page allows the creation of a new player
    $pageTitle = "Create a New Player";
    require "includes/header.php";
?>
<main>
    <form method="post" action="process.php" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" id="first_name" autocomplete="given-name" required />
        </div>

        <div class="mb-3">
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" id="last_name" autocomplete="family-name" required />
        </div>

        <div class="mb-3">
            <label for="position">Position:</label>
            <input type="text" name="position" id="position" required />
        </div>

        <div class="mb-3">
            <label for="phone">Phone Number:</label>
            <input type="tel" name="phone" id="phone" autocomplete="tel" required />
        </div>

        <div class="mb-3">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" autocomplete="email" required />
        </div>

        <div class="mb-3">
            <label for="team_name">Team Name:</label>
            <input type="text" name="team_name" id="team_name" autocomplete="none" required /> <!--Browser may confuse this for full name-->
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
        <div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
        </div>
    </form>
</main>

<?php
    require "includes/footer.php";
?>