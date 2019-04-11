<?php
class Schedule
{
    private $id;
    private $sport;
    private $league;
    private $season;
    private $hometeam;
    private $awayteam;
    private $homescore;
    private $awayscore;
    private $scheduled;
    private $completed;

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
        return "Schedule Name : {$this->league}.";
    }
}
