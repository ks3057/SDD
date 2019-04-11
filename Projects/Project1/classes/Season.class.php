<?php
class Season
{
    private $id;
    private $year;
    private $description;
    private $league;

    public function __set($prop, $val)
    {
        echo "__set() called for $prop:$val<br/>";
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
        return "Season : {$this->year}.";
    }
}
