<?php require "header.php"; ?>

<main>
    <h2>Contact us!</h2>
    <form action="process.php" method="post">
        <fieldset>
            <div>
                <label for="first_name">First name</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>

            <div>
                <label for="last_name">Last name</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>
            <div>
                <label for="email">Email</label>
                <input type="text" id="email" name="email" required>
            </div>
        </fieldset>


        <fieldset>
            <legend>Send us your Message</legend>

            <p>
                <label for="message">Message</label><br>
                <textarea id="message" name="message" rows="6" cols="55" 
                placeholder="Leave your message here..." required></textarea>
            </p>
        </fieldset>

        <p>
        <button type="submit">Send Message</button>
        </p>

    </form>
</main>

<?php require "footer.php"; ?>

