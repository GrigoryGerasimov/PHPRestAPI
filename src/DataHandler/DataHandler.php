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
    
    public static function getData(string $request): ?array
    {
        $dataQueryHandler = new DataQueryHandler();
        $dataReceiver = new DataReceiver();
        
        $requestResult = $dataQueryHandler->makeQuery(self::$connection, $request)->getQueryResult();
        $requestedData = $dataReceiver->fetchData($requestResult)->getData();
        
        $result = null;
        
        if ($requestedData) $result = collectData($requestedData);
        
        return $result;
    }
    
    public static function create(array $postData): string
    {
        try {
            
            $userId = $postData["userId"];
            $id = $postData["id"];
            $title = $postData["title"];
            $body = $postData["body"];
            
            $dataQueryHandler = new DataQueryHandler();
            
            $getPost = self::readOne($id);
            
            if (json_decode($getPost)->status === "failed") {
                
                $creationResult = $dataQueryHandler->makeQuery(
                self::$connection, "INSERT INTO `posts` (`userId`, `id`, `title`, `body`) VALUES ('$userId', '$id', '$title', '$body')"
                )->getQueryResult();
            
                if($creationResult) {
                    
                    http_response_code(201);
                    
                    return DataEncoder::encode([
                        "status" => "success",
                        "result" => "new post created"
                    ]);
                    
                } else {
                    
                    http_response_code(400);
                    
                    throw new \Exception("New post creation failed");
                }
                
            } else {
                
                http_response_code(400);
                
                return DataEncoder::encode([
                    "status" => "failed",
                    "result" => "Post with the same $id already exists"
                ]);
            }
                
        } catch (\Exception $err) {
            
            http_response_code(400);
            
            return DataEncoder::encode([
                "status" => "failed",
                "result" => $err->getMessage()
            ]);
        }
    }
    
    public static function readAll(): string
    {
        try {
            
            $posts = self::getData("SELECT * FROM `posts`");
            
            if ($posts) {
                
                http_response_code(200);
                
                return DataEncoder::encode([
                    "status" => "success",
                    "result" => $posts
                ]);
                
            } else {
                
                http_response_code(404);
                
                throw new \Exception("Posts not found");
            }
            
        } catch (\Exception $err) {
            
            http_response_code(400);
            
            return DataEncoder::encode([
                "status" => "failed",
                "result" => $err->getMessage()
            ]);
        }
    }
    
    public static function readOne(string $id): string
    {
        try {
            
            $post = self::getData("SELECT * FROM `posts` WHERE id = $id");
            
            if ($post) {
                
                http_response_code(200);
                
                return DataEncoder::encode([
                    "status" => "success",
                    "result" => $post
                ]);
                
            } else {
                
                http_response_code(404);
                
                throw new \Exception("Post $id not found");
            }
            
        } catch (\Exception $err) {
            
            http_response_code(400);
            
            return DataEncoder::encode([
                "status" => "failed",
                "result" => $err->getMessage()
            ]);
        }
    }
    
    public static function update(string $id, array $updateData): string
    {
        try {
            
            $dataQueryHandler = new DataQueryHandler();
            
            $getPost = self::readOne($id);
            
            if (json_decode($getPost)->status === "success") {
                
                foreach($updateData as $dataKey => $dataValue) {
                    
                    $updateResult = $dataQueryHandler->makeQuery(self::$connection, "UPDATE `posts` SET `$dataKey`='$dataValue' WHERE id=$id")->getQueryResult();
                    
                    if ($updateResult) {
                        
                        http_response_code(200);
                        
                        return DataEncoder::encode([
                            "status" => "success",
                            "result" => "post $id updated"
                            
                        ]);
                    } else {
                        
                        throw new \Exception("Post $id update failed");
                    }
                }
            } else {
                
                http_response_code(400);
                
                return DataEncoder::encode([
                    "status" => "failed",
                    "result" => "Post $id not found"
                ]);
            }
            
        } catch (\Exception $err) {
            
            http_response_code(400);
            
            return DataEncoder::encode([
                "status" => "failed",
                "result" => $err->getMessage()
            ]);
        }
    }
    
    public static function delete(string $id): string
    {
        try {
            
            $getPost = self::readOne($id);
            
            $dataQueryHandler = new DataQueryHandler();
            
            $deletionResult = $dataQueryHandler->makeQuery(self::$connection, "DELETE FROM `posts` WHERE id=$id")->getQueryResult();
            
            if ($deletionResult && json_decode($getPost)->status === "success") {
                
                http_response_code(200);
                
                return DataEncoder::encode([
                    "status" => "success",
                    "result" => "post $id deleted"
                ]);
                
            } else {
                
                http_response_code(400);
                
                throw new \Exception("Post $id deletion failed");
            }
            
        } catch(\Exception $err) {

            http_response_code(400);
            
            return DataEncoder::encode([
                "status" => "failed",
                "result" => $err->getMessage()
            ]);
        }
    }
}