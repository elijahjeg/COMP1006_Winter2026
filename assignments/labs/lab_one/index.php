<?php
/*
The part I found easy about the lab was creating the Car class and making the functions within.
The more difficult part was requiring everything and it all working together, as well as making connect.php and not having that fail either.

*/
require "header.php"; 
echo "<p> Follow the instructions outlined in instructions.txt to complete this lab. Good luck & have fun!😀 </p>";
require "car.php"; // Require the car file so we can use the Car class
$car = new Car("Honda", "Accord", "2007"); // Create a new instance of Car
echo "<p>{$car->getInfo()}<p/>"; // Echo it to the page
require "connect.php";
require "footer.php";
