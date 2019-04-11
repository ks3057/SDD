<?php
class Team
{
    private $id;
    private $name;
    private $mascot;
    private $sport;
    private $league;
    private $season;
    private $picture;
    private $homecolor;
    private $awaycolor;
    private $maxplayers;

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
        return "Team Name : {$this->name}.";
    }
}
