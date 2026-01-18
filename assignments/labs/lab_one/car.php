<?php
class Car { // Creates a new class
    // Declare the properties of the class
    public string $make;
    public string $model;
    public int $year;

    // Define the instructor; assign the properties to the given values
    public function __construct(string $make, string $model, int $year)
    {
        $this->make = $make;
        $this->model = $model;
        $this->year = $year;
    }

    // Define method to get the info of the car, return it as a string using string formatting
    public function getInfo(): string{
        return "Make: {$this->make} | Model: {$this->model} | Year: {$this->year}";
    }
}