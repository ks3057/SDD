<?php
class Validator
{
    public static function alphaNumeric($value)
    {
        $reg= "/^[A-Za-z0-9]+$/";
        return preg_match($reg, $value);
    }

    public static function alphaNumericSpace($value)
    {
        $reg = "/^[A-Za-z0-9 ]+$/";
        return preg_match($reg, $value);
    }

    public static function numeric($value)
    {
        $reg = "/(^-?\d\d*\.\d*$)|(^-?\d\d*$)|(^-?\.\d\d*$)/";
        return preg_match($reg, $value);
    }
}
