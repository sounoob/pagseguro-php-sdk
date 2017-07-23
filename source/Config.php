<?php
class Conf
{
    const SANDBOX = false;
    const EMAIL = 'financeiro@sounoob.com.br';
    const TOKEN_PRODUCTION = "E735675D6AC38486A9DXA03FD79DD29C";
    const TOKEN_SANDBOX = "58BD30C836DF4A64AD2DDCXF42XAX4B8";


    const TOKEN = Conf::SANDBOX ? Conf::TOKEN_SANDBOX : Conf::TOKEN_PRODUCTION;
}

class URL
{
    const WS = Conf::SANDBOX ? 'https://ws.sandbox.pagseguro.uol.com.br/' : 'https://ws.pagseguro.uol.com.br/';
    const PAGE = Conf::SANDBOX ? 'https://sandbox.pagseguro.uol.com.br/' : 'https://pagseguro.uol.com.br/';
    const STC = Conf::SANDBOX ? 'https://stc.sandbox.pagseguro.uol.com.br/' : 'https://stc.pagseguro.uol.com.br/';
}