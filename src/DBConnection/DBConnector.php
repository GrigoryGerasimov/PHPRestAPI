<?php

namespace PHPRestAPI\RestAPI\DBConnection;


class DBConnector implements DBConnectorInterface
{
    private static ?self $instance = null;
    private static ?string $name = null;

    private function __construct() {}
    
    public static function getInstance(): self
    {
        if (self::$instance === null) self::$instance = new self();
        
        return self::$instance;
    }
    
    private static function normalizeName(string $name): string
    {
        return strtolower($name);
    }
    
    public static function connect(string $name): \mysqli|false
    {
        $normalizedName = self::normalizeName($name);
        
        try {
            $connection = match($normalizedName) {
                "mysqli" => mysqli_connect("localhost", "root", "root", "phprestapi", "8889")
            };
            
        } catch(\UnhandledMatchError $err) {
            exit($err->message);
        }
        
        return $connection;
    }
    
    public static function getInstanceName(): ?string
    {
        return self::$name;
    }
    
    public static function setInstanceName(string $name): void
    {
        if (self::$name === null) self::$name = self::normalizeName($name); 
    }
    
    public function __wakeup() {}
    
    public function __clone() {}
}