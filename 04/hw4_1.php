<?php

class Person
{
    private $last;
    private $first;
    private $height;//in inches
    private $weight;//in lbs

    public function __construct($last = "Spade", $first = "Sam")
    {
        $this->last = $last;
        $this->first = $first;
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    public function calculate_bmi()
    {
        $bmi = 705 * $this->weight / ($this->height * $this->height);
        return "Hi, {$this->first} {$this->last}. Your BMI is " .round($bmi, 2) .".";
    }
}
