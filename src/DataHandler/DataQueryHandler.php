<?php

namespace PHPRestAPI\RestAPI\DataHandler;


class DataQueryHandler
{    
    private \mysqli_result|bool|null $requestResult = null;
    
    public function makeQuery(\mysqli $connection, string $sql): self
    {
        $this->requestResult = mysqli_query($connection, $sql);
        
        return $this;
    }
    
    public function getQueryResult(): \mysqli_result|bool|null
    {
        return $this->requestResult;
    }
}