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
    private static $email = 'testador@sounoob.com.br';
    /**
     * @var string
     */
    private static $tokenProduction = "8138C6CF07B64F6B852774D6D4B03CB7";
    /**
     * @var string
     */
    private static $tokenSandbox = "B4BD2EF8E723436F9189B79DD1FB544A";

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
