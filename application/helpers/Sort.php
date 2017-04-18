<?php
namespace Jesh\Helpers;

class Sort
{
    const ASCENDING = SORT_ASC;
    const DESCENDING = SORT_DESC;

    public static function ListArray($array, $sortType = Sort::ASCENDING)
    {
        if($sortType == Sort::ASCENDING)
        {
            return sort($array);
        }
        else
        {
            return rsort($array);
        }
    }

    public static function AssociativeArray(
        $array, $subkey, $sortType = Sort::ASCENDING
    )
    {
        usort($array, Sort::GetSortVariable($subkey, $sortType, true));
        return $array;
    }

    public static function ObjectArray(
        $array, $subkey, $sortType = Sort::ASCENDING
    )
    {
        usort($array, Sort::GetSortVariable($subkey, $sortType, false));
        return $array;
    }

    private static function GetSortVariable(
        $subkey, $sortType, $is_array = true
    ) 
    {
        switch($sortType) 
        {
            case Sort::ASCENDING:
                return function ($a, $b) use ($subkey, $is_array) { 
                    if(!$is_array) 
                    {
                        $a = (array) $a;
                        $b = (array) $b;
                    }
                    return strcmp($a[$subkey], $b[$subkey]); 
                };
            case Sort::DESCENDING:
                return function ($a, $b) use ($subkey, $is_array) {
                    if(!$is_array) 
                    {
                        $a = (array) $a;
                        $b = (array) $b;
                    }
                    return strcmp($b[$subkey], $a[$subkey]);
                };
        }
    }
}
