<?php
namespace Jesh\Helpers;

Class Sort
{
    public static function AssociativeArray(
        $array, $subkey, $sortType = SORT_ASC
    )
    {
        $sortFunction = Sort::GetSortVariable($subkey, $sortType);
        usort($array, $sortFunction);

        return $array;
    }

    private static function GetSortVariable($subkey, $sortType = SORT_ASC) 
    {
        switch($sortType) 
        {
            case SORT_ASC:
                return function ($a, $b) use ($subkey) { 
                    return strcmp($a[$subkey], $b[$subkey]); 
                };
            case SORT_DESC:
                return function ($a, $b) use ($subkey) {
                    return strcmp($b[$subkey], $a[$subkey]);
                };
        }
    }

}