<?php
date_default_timezone_set('America/Sao_Paulo');

/**
 * Class Config
 */
class Config
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
    private static $tokenProduction = "5179DCD806314BD6A77B774DF6148CA9";
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

