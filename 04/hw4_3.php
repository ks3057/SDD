<?php

class BritishPerson extends Person
{
    public function __construct($last = "Smith", $first = "Harry")
    {
        parent::__construct($last, $first);
    }

    public function setFirstName($first)
    {
        parent::setFirstName($first);
    }

    public function setLastName($last)
    {
        parent::setLastName($last);
    }

    public function setHeight($height)
    {
        parent::setHeight($height / 2.54);
    }

    public function setWeight($weight)
    {
        parent::setWeight($weight * 2.205);
    }

    public function getFirstName()
    {
        return parent::getFirstName();
    }

    public function getLastName()
    {
        return parent::getLastName();
    }

    public function getHeight()
    {
        return parent::getHeight();
    }

    public function getWeight()
    {
        return parent::getWeight();
    }

    public function calculate_bmi()
    {
        return parent::calculate_bmi();
    }
}
