<?php

namespace PHPRestAPI\RestAPI;


header("Content-type: application/json");

require_once("../vendor/autoload.php");
require_once("DBConnection/DBConnector.php");
require_once("DataHandler/DataHandler.php");

$splitQueryPath = explode("/", $_GET["q"]);
$pathId = $splitQueryPath[count($splitQueryPath) - 1];

$requestMethod = $_SERVER["REQUEST_METHOD"];
$postData = $_POST;

$updateData = file_get_contents("php://input");
parse_str($updateData, $updateOutput);

$connection = DBConnection\DBConnector::getInstance()::connect("mysqli");
$init = DataHandler\DataHandler::initializeConnection($connection);

try {
    
    $data = match($requestMethod) {
        "GET" => (int) $pathId ? $init::readOne($pathId) : $init::readAll(),
        "POST" => $pathId === "posts" ? $init::create($postData) : throw new \Exception("A new post should be created from the posts list"),
        "PATCH" => (int) $pathId ? $init::update($pathId, $updateOutput) : throw new \Exception("Please select a post id to update"),
        "DELETE" => (int) $pathId ? $init::delete($pathId) : throw new \Exception("Please select a post id to delete")
    };
    
} catch (\UnhandledMatchError|\Exception $err) {
    
    http_response_code(400);
    
    exit(json_encode([
        "status" => "failed",
        "result" => $err->getMessage()
    ]));
}

var_dump($data);