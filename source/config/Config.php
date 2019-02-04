<?php
namespace Sounoob\pagseguro\config;

use Sounoob;

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
    private static $email = 'seu@email.com.br';
    /**
     * @var string
     */
    private static $token = "BD65179DCD806314A77B774DF6148CA9";

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
        return self::$token;
    }

    /**
     * @return bool
     */
    public static function isSandbox()
    {
        return self::$sandbox;
    }

    /**
     * @deprecated
     */
    public static function setSandbox()
    {
        self::$sandbox = true;
    }

    /**
     * @deprecated
     */
    public static function setProduction()
    {
        self::$sandbox = false;
    }

    public static function setAccountCredentials($email, $token)
    {
        self::$email = $email;
        self::$token = $token;
        
        \Sounoob\pagseguro\config\Discover::detect_env();
    }
}

