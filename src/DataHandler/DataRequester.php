<?php

namespace PHPRestAPI\RestAPI\DataHandler;


class DataRequester
{    
    private \mysqli_result|bool|null $requestResult = null;
    
    public function requestData(\mysqli $connection): self
    {
        $this->requestResult = mysqli_query($connection, "SELECT * FROM `posts`");
        
        return $this;
    }
    
    public function getRequestResult(): \mysqli_result|bool|null
    {
        return $this->requestResult;
    }
}