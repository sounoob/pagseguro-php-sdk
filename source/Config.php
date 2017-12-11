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
    private static $email = 'dev@sounoob.com.br';
    /**
     * @var string
     */
    private static $tokenProduction = "497226512D9D415F95AAC791F72778DE";
    /**
     * @var string
     */
    private static $tokenSandbox = "CEEE2C5274A149588A3A3F4211BE9C42";

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

    public static function setAccountCredentials($email, $token, $isSandbox = true)
    {
        self::$email = $email;

        if($isSandbox === true) {
            self::setSandbox();
            self::$tokenSandbox = $token;
        }else{
            self::setProduction();
            self::$tokenProduction = $token;
        }
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
