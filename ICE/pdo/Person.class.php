<?php
class Person
{
    public function whoami()
    {
        return "I am {$this->FirstName} {$this->LastName} and my nickname is {$this->NickName}.";
    }
}
