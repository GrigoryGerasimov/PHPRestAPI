<?php

namespace PHPRestAPI\RestAPI\DataHandler;


class DataRequester
{    
    private \mysqli_result|bool|null $requestResult = null;
    
    public function requestData(\mysqli $connection, string $sql): self
    {
        $this->requestResult = mysqli_query($connection, $sql);
        
        return $this;
    }
    
    public function getRequestResult(): \mysqli_result|bool|null
    {
        return $this->requestResult;
    }
}