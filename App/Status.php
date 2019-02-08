<?php

namespace App; 


class Status
{
    const NULL_STATUS = [
        '1' => [ '1' => ' . ', '2' => ' . ', '3' => ' . ' ],
        '2' => [ '1' => ' . ', '2' => ' . ', '3' => ' . ' ],
        '3' => [ '1' => ' . ', '2' => ' . ', '3' => ' . ' ],
    ];

    public static function getStatus()
    {
        return json_decode(file_get_contents('status.json'), true);
    }

    public static function getWinList()
    {
        return json_decode(file_get_contents('App/winList.json'), true);
    }

    public static function isEmpty($status)
    {
        return empty($status);
    }

    public static function record($status)
    {
        file_put_contents('status.json', json_encode($status, JSON_PRETTY_PRINT));
    }

    public static function reset()
    {
        file_put_contents('status.json', json_encode(self::NULL_STATUS));
    }
}