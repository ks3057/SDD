<?php
class User
{
    private $username;
    private $role;
    private $password;
    private $team;
    private $league;

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
        return "Username: {$this->username}.";
    }
}
