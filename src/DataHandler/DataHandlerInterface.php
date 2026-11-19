<?php

namespace PHPRestAPI\RestAPI\DataHandler;


interface DataHandlerInterface
{
    public static function create(array $postData);
    public static function readAll();
    public static function readOne(string $id);
    public static function update(string $id, array $updateData);
    public static function delete(string $id);
}