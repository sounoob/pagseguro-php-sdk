<?php
/**
 * Created by PhpStorm.
 * User: leode
 * Date: 22/07/2017
 * Time: 15:49
 */

class Utils
{
    public function only_numbers($number)
    {
        return preg_replace('/[^0-9]/', '', $number);
    }

    public function debug($var)
    {
        print_r($var);
        echo "<br>";
        var_dump($var);
        exit();
    }

    public function show(){
        var_dump($this);
    }
}