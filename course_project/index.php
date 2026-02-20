<?php
    $pageTitle = "Add a New Player";
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
            <label for="pos">Position:</label>
            <input type="text" name="pos" id="pos" required />
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
            <label for="team">Team Name:</label>
            <input type="text" name="team" id="team" autocomplete="none" required /> <!--Browser may confuse this for full name-->
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