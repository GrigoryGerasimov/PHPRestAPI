<?php

namespace PHPRestAPI\RestAPI\DataHandler;


class DataReceiver
{
    private ?array $data = null;
    
    public function fetchData(\mysqli_result $requestResult): self
    {
        $this->data = mysqli_fetch_all($requestResult, MYSQLI_ASSOC);
        
        return $this;
    }
    
    public function getData(): ?array
    {
        return $this->data;
    }
}




