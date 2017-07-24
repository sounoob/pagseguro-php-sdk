<?php

/**
 * Class Conf
 */
class Conf
{
    /**
     * @var bool
     */
    private static $sandbox = false;
    /**
     * @var string
     */
    private static $email = 'financeiro@sounoob.com.br';
    /**
     * @var string
     */
    private static $tokenProduction = "E735675D6AC38486A9DXA03FD79DD29C";
    /**
     * @var string
     */
    private static $tokenSandbox = "58BD30C836DF4A64AD2DDCXF42XAX4B8";

    /**
     * @return string
     */
    public static function getEmail()
    {
        return self::$email;
    }

    /**
     * @return string
     */
    public static function getToken()
    {
        return self::isSandbox() ? self::$tokenSandbox : self::$tokenProduction;
    }

    /**
     * @return bool
     */
    public static function isSandbox()
    {
        return self::$sandbox;
    }

    /**
     *
     */
    public static function setSandbox()
    {
        self::$sandbox = true;
    }

    /**
     *
     */
    public static function setProduction()
    {
        self::$sandbox = false;
    }
}

/**
 * Class URL
 */
class URL
{
    /**
     * @return string
     */
    public static function getWs()
    {
        return Conf::isSandbox() ? 'https://ws.sandbox.pagseguro.uol.com.br/' : 'https://ws.pagseguro.uol.com.br/';
    }

    /**
     * @return string
     */
    public static function getPage()
    {
        return Conf::isSandbox() ? 'https://sandbox.pagseguro.uol.com.br/' : 'https://pagseguro.uol.com.br/';
    }

    /**
     * @return string
     */
    public static function getStc()
    {
        return Conf::isSandbox() ? 'https://stc.sandbox.pagseguro.uol.com.br/' : 'https://stc.pagseguro.uol.com.br/';
    }
}