<?php

$userInfo = [
    "First Name" => "fname",
    "Last Name" => "lname",
    "Position" => "pos",
    "Phone Number" => "phone",
    "Email" => "email",
    "Team Name" => "team",
];

foreach ($userInfo as $name => $id):
?>

<p><?=$name?>: <?= $_GET[$id] ?>

<?php endforeach; ?>