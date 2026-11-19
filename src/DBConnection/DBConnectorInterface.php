<?php

namespace PHPRestAPI\RestAPI\DBConnection;


interface DBConnectorInterface
{
    public static function getInstance(): self;
}