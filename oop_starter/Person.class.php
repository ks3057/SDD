<?php
class Person
{
    private $last;
    private $first;

    // constructor here...
    public function __construct($last = "TBD", $first = "TBD")
    {
        $this->last = $last;
        $this->first = $first;
    }

    public function getFirstName()
    {
        return $this->first;
    }

    public function getLastName()
    {
        return $this->last;
    }

    public function sayHello()
    {
        return "Hi there! My first name is {$this->first} and my last name is ".
            $this->getLastName()."<br />";
    }

    public function fashion()
    {
        echo "jeans";
    }
}
