<?php
namespace Jesh\Helpers;

Class StringHelper
{
    public static function NoBreakString($string)
    {
        return trim(preg_replace('/\s+/', ' ', $string));
    }

    public static function MakeIndex($string)
    {
        return strtolower(str_replace(' ', '-', $string));
    }

    public static function UnmakeIndex($string)
    {
        return ucwords(str_replace('-', ' ', $string));
    }
}