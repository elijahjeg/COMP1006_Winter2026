<!DOCTYPE html>
<html>
    <head>
        <title>Team Tracker</title>
    </head>
    <body>
        <h1>Team Tracker</h1>
        <form method="get" action="process_form.php">
            <div>
                <label for="fname">First Name:</label>
                <input type="text" name="fname" id="fname" autocomplete="given-name" />
            </div>

            <div>
                <label for="lname">Last Name:</label>
                <input type="text" name="lname" id="lname" autocomplete="family-name" />
            </div>
        
            <div>
                <label for="pos">Position:</label>
                <input type="text" name="pos" id="pos" />
            </div>

            <div>
                <label for="phone">Phone Number:</label>
                <input type="tel" name="phone" id="phone" autocomplete="tel" />
            </div>
            
            <div>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" autocomplete="email" />
            </div>

            <div>
                <label for="team">Team Name:</label>
                <input type="text" name="team" id="team" autocomplete="none"/> <!--Browser may confuse this for full name-->
            </div>

            <div>
                <button type="submit">Submit</button>
                <button type="submit">Reset</button>
            </div>
        </form>
    </body>
</html>