<?php
class BusinessMajor extends Person
{
    //you cannot overload functions in php, just override
    public function fashion()
    {
        return "suit and tie";
    }
}
