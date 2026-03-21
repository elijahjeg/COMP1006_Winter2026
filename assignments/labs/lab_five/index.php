<?php
require "includes/header.php";

?>
<main class="container mt-4">
    <h1 class="mb-4">Upload an Image</h1>
    <form method="post" action="process.php" enctype="multipart/form-data">
        <div>
            <label for="image">Select an image to upload:</label>
            <input 
                type="file" 
                name="image" 
                id="image" 
                accept=".jpg,.jpeg,.png,.webp"
                class="form-control mb-4"
                required
            />
        </div>
        <div>
            <button class="btn btn-primary" type="submit">Upload Image</button>
        </div>
    </form>
</main>
</body>
</html>
