<?php 
class Car {
    //properties 
    public string $make; 
    public string $model;
    public int $year; 

    //constructor function 
    public function __construct(string $make, string $model, int $year) {
        //$this refers to the current instance of the object 
        //these assignments bind the incoming arguments to the object's properties 
        $this->make = $make; 
        $this->model = $model;
        $this->year = $year; 
    }

    //method 
    public function getCar() : string {
        return "Make : {$this->make} | Model: {$this->model} | Year : {$this->year}";

    }
}
//create a new car object 
$car = new Car("Honda", "Civic", 2010);

//cal the getCar() method and echo/display in browser
echo $car->getCar(); 