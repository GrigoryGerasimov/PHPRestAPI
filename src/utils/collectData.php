<?php

function collectData(array $data): array
{
    $dataCollection = array();

    foreach($data as $item) {
        array_push($dataCollection, $item);
    }
    
    return $dataCollection;
}