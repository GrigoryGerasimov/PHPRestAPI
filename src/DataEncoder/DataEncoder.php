<?php

namespace PHPRestAPI\RestAPI\DataEncoder;


class DataEncoder
{
    private ?array $dataCollection = null;
    
    public function __construct(array $dataCollection)
    {
        $this->dataCollection = $dataCollection;
    }
    
    public function encode(): string|false
    {
        return json_encode($this->dataCollection);
    }
}