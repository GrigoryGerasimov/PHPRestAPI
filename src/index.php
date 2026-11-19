<?php

namespace PHPRestAPI\RestAPI;


header("Content-type: application/json");

require_once("../vendor/autoload.php");
require_once("DBConnection/DBConnector.php");
require_once("DataHandler/DataHandler.php");

$splitQueryPath = explode("/", $_GET["q"]);
$pathId = $splitQueryPath[count($splitQueryPath) - 1];

$requestMethod = $_SERVER["REQUEST_METHOD"];

$connection = DBConnection\DBConnector::getInstance()::connect("mysqli");
$init = DataHandler\DataHandler::initializeConnection($connection);

try {
    $data = match($requestMethod) {
        "GET" => (int) $pathId ? $init::readOne($pathId) : $init::readAll(),
        "POST" => "",
        "PATCH" => "",
        "DELETE" => ""
    };
} catch (\UnhandledMatchError $err) {
    exit($err->message);
}

var_dump($data);