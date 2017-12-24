<?php

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
        return Config::isSandbox() ? 'https://ws.sandbox.pagseguro.uol.com.br/' : 'https://ws.pagseguro.uol.com.br/';
    }

    /**
     * @return string
     */
    public static function getPage()
    {
        return Config::isSandbox() ? 'https://sandbox.pagseguro.uol.com.br/' : 'https://pagseguro.uol.com.br/';
    }

    /**
     * @return string
     */
    public static function getStc()
    {
        return Config::isSandbox() ? 'https://stc.sandbox.pagseguro.uol.com.br/' : 'https://stc.pagseguro.uol.com.br/';
    }
}
