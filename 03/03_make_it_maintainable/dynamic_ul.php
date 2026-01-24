<?php
$items = ["Home", "About", "Contact"];

?>

<ul>
<?php foreach ($items as $item): ?>
    <li><?= $item ?></li>
<?php endforeach; ?>
</ul>