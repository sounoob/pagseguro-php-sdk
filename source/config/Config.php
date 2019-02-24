<?php

namespace Sounoob\pagseguro\config;

/**
 * Class Config
 * @package Sounoob\pagseguro\config
 */
class Config
{
    /**
     * @var bool
     */
    private static $sandbox = null;
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
     * @throws \Exception
     */
    public static function isSandbox()
    {
        if (self::$sandbox === null) {
            Discover::detect_env();
        }
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

    /**
     * @param string $email
     * @param string $token
     */
    public static function setAccountCredentials($email, $token)
    {
        if (self::$sandbox !== null) {
            throw new \InvalidArgumentException('The e-mail and token was already defined before');
        }
        self::$email = $email;
        self::$token = $token;
    }
}

