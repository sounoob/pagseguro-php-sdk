<?php
namespace Sounoob\pagseguro\config;

/**
 * Class Discover
 */
class Discover
{   
    public static  function detect_env()
    {
        \Sounoob\pagseguro\config\Config::setProduction();
        
        if(self::request_test() === false) {
            \Sounoob\pagseguro\config\Config::setSandbox();
            
            if(self::request_test() === false) {
                throw new \Exception('E-mail or token is invalid: ' . \Sounoob\pagseguro\config\Config::getEmail() . ' - ' . \Sounoob\pagseguro\config\Config::getToken());
            }
        }
    }
    
    private static function request_test()
    {
        try {
            $transactions = new \Sounoob\pagseguro\SearchTransaction();
            $transactions->setReference('boonuos');
            $transactions->find();            
            return true;
            
        } catch (\Exception $e) {
            return false;
        }
    }
}

