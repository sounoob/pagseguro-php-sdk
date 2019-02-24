<?php
namespace Sounoob\pagseguro\config;

/**
 * Class Discover
 * @package Sounoob\pagseguro\config
 */
class Discover
{
    /**
     * @throws \Exception
     */
    public static  function detect_env()
    {
        Config::setProduction();
        
        if(self::request_test() === false) {
            Config::setSandbox();
            
            if(self::request_test() === false) {
                throw new \Exception('E-mail or token is invalid: ' . Config::getEmail() . ' - ' . Config::getToken());
            }
        }
    }

    /**
     * @return bool
     */
    private static function request_test()
    {
        try {
            $transactions = new \Sounoob\pagseguro\SearchTransaction();
            $transactions->setReference('boonuos');
            $transactions->send();            
            return true;
            
        } catch (\Exception $e) {
            return false;
        }
    }
}

