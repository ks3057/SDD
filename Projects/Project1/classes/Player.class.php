<?php
class Player
{
    private $id;
    private $firstname;
    private $lastname;
    private $dateofbirth;
    private $jerseynumber;
    private $team;

    public function __set($prop, $val)
    {
        $this->$prop = $val;
    }

    public function __get($prop)
    {
        if ($prop != "props") {
            return $this->$prop;
        }
    }

    public function whoami()
    {
        return "Name: {$this->firstname}.";
    }
}
