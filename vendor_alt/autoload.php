<?php
spl_autoload_register(function($class) {
    $prefix = 'Sounoob\\pagseguro\\';
    
    if ( ! substr($class, 0, strlen($prefix) -1) === $prefix) {
        return;
    }
    
    $class = substr($class, strlen($prefix));
    $location = __DIR__ . '/../source/' . str_replace('\\', '/', $class) . '.php';
    
    if (is_file($location)) {
        require_once($location);
    }
});