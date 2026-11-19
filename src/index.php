<?php

namespace PHPRestAPI\RestAPI;


header("Content-type: application/json");

require_once("../vendor/autoload.php");
require_once("connect.php");

$postsCollection = array();

$queryResult = mysqli_query($connect, "SELECT * FROM `posts`");
$getPosts = mysqli_fetch_all($queryResult, MYSQLI_ASSOC);

foreach($getPosts as $postValue) {
    array_push($postsCollection, $postValue);
}

var_dump(json_encode($postsCollection));