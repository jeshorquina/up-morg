<?php
namespace Jesh\Helpers;

Class Sort
{
    const ASCENDING = SORT_ASC;
    const DESCENDING = SORT_DESC;

    public static function AssociativeArray(
        $array, $subkey, $sortType = Sort::ASCENDING
    )
    {
        $sortFunction = Sort::GetSortVariable($subkey, $sortType);
        usort($array, $sortFunction);

        return $array;
    }

    private static function GetSortVariable($subkey, $sortType) 
    {
        switch($sortType) 
        {
            case Sort::ASCENDING:
                return function ($a, $b) use ($subkey) { 
                    return strcmp($a[$subkey], $b[$subkey]); 
                };
            case Sort::DESCENDING:
                return function ($a, $b) use ($subkey) {
                    return strcmp($b[$subkey], $a[$subkey]);
                };
        }
    }

}