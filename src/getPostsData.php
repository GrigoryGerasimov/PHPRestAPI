<?php

namespace PHPRestAPI\RestAPI;


require_once("DBConnection/DBConnector.php");
require_once("DataHandler/DataRequester.php");
require_once("DataHandler/DataReceiver.php");
require_once("DataEncoder/DataEncoder.php");

$postsCollection = array();

$connection = DBConnection\DBConnector::getInstance()::connect("mysqli");
$dataRequester = new DataHandler\DataRequester();
$requestResult = $dataRequester->requestData($connection)->getRequestResult();
$dataReceiver = new DataHandler\DataReceiver();
$data = $dataReceiver->fetchData($requestResult)->getData();

foreach($data as $item) {
    array_push($postsCollection, $item);
}

$dataEncoder = new DataEncoder\DataEncoder($postsCollection);
$encodedData = $dataEncoder->encode();