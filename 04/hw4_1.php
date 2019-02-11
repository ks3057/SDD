<?php

class Person
{
    private $last;
    private $first;
    private $height;
    private $weight;
    private $bmi;

    public function __construct($last = "Spade", $first = "Sam")
    {
        $this->last = $last;
        $this->first = $first;
    }

    public function setFirstName($first)
    {
        $this->first = $first;
    }

    public function setLastName($last)
    {
        $this->last = $last;
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    public function getFirstName()
    {
        return $this->first;
    }

    public function getLastName()
    {
        return $this->last;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function calculate_bmi()
    {
        $this->bmi = 705 * $this->weight / ($this->height * $this->height);
        return "Hi, {$this->first} {$this->last}. Your BMI is " .round($this->bmi, 2);
    }
}
