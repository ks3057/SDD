<?php

require_once "hw4_1.php";

class BritishPerson extends Person
{
    public function __construct($last = "Smith", $first = "Harry")
    {
        parent::__construct($last, $first);
    }

    public function setHeight($height)
    {
        //conversion from cm to inches
        parent::setHeight($height / 2.54);
    }

    public function setWeight($weight)
    {
        //conversion from kilo to pounds
        parent::setWeight($weight * 2.205);
    }
}
