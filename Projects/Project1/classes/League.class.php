<?php
class League
{
    private $id;
    private $name;

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
        return "League : {$this->name}.";
    }
}
