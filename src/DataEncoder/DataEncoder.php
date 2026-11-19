<?php

namespace PHPRestAPI\RestAPI\DataEncoder;


final class DataEncoder
{
    private static ?array $dataCollection = null;
    
    public static function encode(array $dataCollection): string|false
    {
        self::$dataCollection = $dataCollection;
        
        return json_encode(self::$dataCollection);
    }
    
    public static function getDataCollection(): ?array
    {
        return self::$dataCollection;
    }
}