<?php
    $pageTitle = "Create a New Player";
    require "includes/header.php";
?>
<main>
    <form method="post" action="process.php">
        <div>
            <label for="fname">First Name:</label>
            <input type="text" name="fname" id="fname" autocomplete="given-name" required />
        </div>

        <div>
            <label for="lname">Last Name:</label>
            <input type="text" name="lname" id="lname" autocomplete="family-name" required />
        </div>
    
        <div>
            <label for="position">Position:</label>
            <input type="text" name="position" id="position" required />
        </div>

        <div>
            <label for="phone">Phone Number:</label>
            <input type="tel" name="phone" id="phone" autocomplete="tel" required />
        </div>
        
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" autocomplete="email" required />
        </div>

        <div>
            <label for="team_name">Team Name:</label>
            <input type="text" name="team_name" id="team_name" autocomplete="none" required /> <!--Browser may confuse this for full name-->
        </div>

        <div>
            <button type="submit">Submit</button>
            <button type="reset">Reset</button>
        </div>
    </form>
</main>

<?php
    require "includes/footer.php";
?>