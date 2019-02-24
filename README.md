# Biblioteca de integração PagSeguro para PHP
[![Build Status](https://travis-ci.org/sounoob/pagseguro-php-sdk.svg?branch=master)](https://travis-ci.org/sounoob/pagseguro-php-sdk)
[![Total Downloads](https://poser.pugx.org/sounoob/pagseguro-php-sdk/d/total.svg)](https://packagist.org/packages/sounoob/pagseguro-php-sdk)
[![Latest Stable Version](https://poser.pugx.org/sounoob/pagseguro-php-sdk/v/stable)](https://packagist.org/packages/sounoob/pagseguro-php-sdk)
[![License](https://poser.pugx.org/sounoob/pagseguro-php-sdk/license)](https://packagist.org/packages/sounoob/pagseguro-php-sdk)


Uma biblioteca do PagSeguro que qualquer noob pode usar, editar, contribuir, melhorar e seja lá o que eles quiserem fazer... 

A ideia disso é ter um lugar onde terá o suporte a todas APIs disponíveis do PagSeguro, de uma forma onde deverá ser mais atualizada que a versão oficial.

Aqui seu pull request é bem-vindo, desde que mantenha a ideia inicial da API, manter ela de um jeito que qualquer noob se sinta em casa.

O SDK oficial é lindo, mas é difícil de editar os arquivos, quem não manja de PHP pode ficar perdido. A nossa, usaremos a simplicidade, não precisa ser rápido nem lindo, só precisa funcionar e estar bem atualizado o resto vamos refratorando...

## Instalação
> Nota: Recomendamos a instalação via **Composer**. Você também pode baixar o repositório como [arquivo zip] ou fazer um clone via Git.
 
### Instalação via Composer
> Para baixar e instalar o Composer no seu ambiente acesse https://getcomposer.org/download/ e caso tenha dúvidas de como utilizá-lo consulte a [documentação oficial do Composer].

É possível instalar a biblioteca pagseguro-php-sdk([sounoob/pagseguro-php-sdk]) via Composer de duas maneiras:

- Executando o comando para adicionar a dependência automaticamente
  ```
  php composer.phar require pagseguro/pagseguro-php-sdk
  ```

**OU**

- Adicionando a dependência ao seu arquivo ```composer.json```
  ```composer.json
  {
      "require": {
         "sounoob/pagseguro-php-sdk" : ">=1.0"
      }
  }
  ```
 
### Instalação manual
 - Baixe o repositório como [arquivo zip] ou faça um clone;
 - Descompacte os arquivos em seu computador;
 - Execute o comando ```php composer.phar install``` no local onde extraiu os arquivos.
 
### Instalação sem composer
 - Baixe o repositório como [arquivo zip] ou faça um clone;
 - Descompacte os arquivos em seu computador;
 - Renomei a pasta `vendor_alt` para `vendor`
 - Baixe o *[projeto core](https://github.com/sounoob/pagseguro-php-sdk-core)* e copie o conteúdo da pasta source para dentro da nossa pasta source.  
 
 Como usar
 ---------
 O diretório *[example](example)* contém exemplos das mais diversas chamadas à API do PagSeguro utilizando a biblioteca e o diretório *[source](source)* contém a biblioteca propriamente dita (código fonte).
