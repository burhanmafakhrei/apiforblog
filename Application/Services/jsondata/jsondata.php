<?php


namespace Application\Services\jsondata;


class jsondata
{
    public static function ReturnJson(array $data)
    {
        header('Content-type: application/json');
        echo json_encode($data);
    }
}