<?php

require "header.php";

// Grab all the inputs from the form and sanitize them with the designated filters
$firstName = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS); 
$lastName = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS); 
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

// Initialize an array to hold error messages
$errors = []; 

// All of the required fields are validated client-side, but we need to re-validate server-side to be safe


// Validate required text fields
if ($firstName === null || $firstName === '') {
    $errors[] = "First Name is Required."; 
}

if ($lastName === null || $lastName === '') {
    $errors[] = "Last Name is Required."; 
}

// Validate required email field
if ($email === null || $email === '') {
    $errors[] = "Email is Required"; 
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Email must be a valid email"; 
}

// Validate required message field
if ($message === null || $message === '') {
    $errors[] = "Message is Required"; 
}
 

// Check to see if there are any errors, display them and exit the script
if ( !empty($errors) ) 
    {
        foreach ($errors as $error) : ?>
            <li><?php echo $error; ?> </li>
        <?php endforeach;

        // Stop the rest of the script from executing
        exit; 
    }

?>


<main>
    <!-- Use the name variables to display the user's information -->
    <?php echo "<h2> Thanks for getting in touch " . $firstName . " " . $lastName . "!</h2>"; ?>

    <!-- Display the user's message -->
    <h3> Your Message: </h3>
    <p><?php echo $message; ?></p>
    </ul>
</main>


<?php
// Send an email to the bakery with the user's message
mail("info@bakery.com", "New Message from Contact Form", $message); 
?> 

<?php require "footer.php"; ?>