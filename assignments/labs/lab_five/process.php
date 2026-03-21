<?php
require "includes/header.php";

// Make sure this page was requested through the form
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request");
}

$error = '';
$image = $_FILES['image'];
// Check if an image was uploaded
if (isset($image) && $image['error'] !== UPLOAD_ERR_NO_FILE){
    // Make sure the image was uploaded successfully
    if ($image['error'] !== UPLOAD_ERR_OK){
        $error = 'Error uploading image';
    }
    else {
        // Array to hold allowed file types
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];

        // Detect the file type of the image
        $detectedType = mime_content_type($image['tmp_name']);

        // Check if the detected file type is an allowed type
        if (!in_array($detectedType, $allowedTypes, true)) {
            $error = 'Invalid image type. The allowed image types are: JP(E)G, PNG, AND WEBP';
        }

        // Limit the file size to 2 MB
        elseif ($image['size'] > 2 * 1024 * 1024){
            $error = 'Max image size of 2MB exceeded.';
        }

        else {
            // Grab the extension of the image
            $extension = pathinfo($image['name'], PATHINFO_EXTENSION);

            // Make a unique filename to privent file overwrites
            $safeFilename = uniqid('product_', true) . '.' . strtolower($extension);

            // Get the full path that the file will be stored
            $destination = __DIR__ . '/uploads/' . $safeFilename;

            if (move_uploaded_file($image['tmp_name'], $destination)){
                // Get the relative path so we can display it to the user.
                $imagePath = 'uploads/' . $safeFilename;
            }
            else {
                $error = 'Failed to move the uploaded image.';
            }
        }
    }
}

// Check if an error happened
if ($error == ''):?>
<main class="container mt-4">
    <h2 class="">Profile Picture Uploaded Successfully</h2>
    <img src="<?= $imagePath ?>" height="500px" width="500px">
    <br />


<?php else: ?>
<main class="container mt-4">
    <h2>File was not uploaded</h2>
    <p><strong>Error message:</strong> <?= $error ?></p>
<?php endif; ?>

<a class="btn btn-primary mt-4" href="index.php">Go to Home</a>
</main>
</body>
</html>