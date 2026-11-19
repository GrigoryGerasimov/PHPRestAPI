<?php

namespace PHPRestAPI\RestAPI\DataHandler;

use PHPRestAPI\RestAPI\DataEncoder\DataEncoder;


require_once "utils/collectData.php";



class DataHandler implements DataHandlerInterface
{
    private static $connection = null;
    
    public static function initializeConnection($connection): self
    {
        if (self::$connection === null) self::$connection = $connection;
        
        return new self();
    }
    
    public static function getConnection()
    {
        return self::$connection;
    }
    
    public static function getData(string $request): string
    {
        $dataRequester = new DataRequester();
        $dataReceiver = new DataReceiver();
        
        $requestResult = $dataRequester->requestData(self::$connection, $request)->getRequestResult();
        $requestedData = $dataReceiver->fetchData($requestResult)->getData();
        
        $postsCollection = [];
        
        if ($requestedData) $postsCollection = collectData($requestedData);
        
        $dataEncoder = new DataEncoder($postsCollection);
        
        return $dataEncoder->encode();
    }
    
    public static function create()
    {
        
    }
    
    public static function readAll(): string
    {
        return self::getData("SELECT * FROM `posts`");
    }
    
    public static function readOne(string $id): string
    {
        return self::getData("SELECT * FROM `posts` WHERE id = $id");
    }
    
    public static function update()
    {
        
    }
    
    public static function delete()
    {
        
    }
}