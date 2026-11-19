<?php

namespace PHPRestAPI\RestAPI\DataHandler;


interface DataHandlerInterface
{
    public static function create();
    public static function readAll();
    public static function readOne(string $id);
    public static function update();
    public static function delete();
}