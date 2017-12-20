<?php
/**
 * Created by PhpStorm.
 * User: leode
 * Date: 22/07/2017
 * Time: 15:49
 */

class Utils
{
    static public function onlyNumbers($number)
    {
        return preg_replace('/[^0-9]/', '', $number);
    }
}