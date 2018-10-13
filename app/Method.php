<?php

namespace App;

class Method
{
    public static function date_format($date, $format)
    {
        $d = date_create($date);
        return date_format($d, $format);
    }
}
