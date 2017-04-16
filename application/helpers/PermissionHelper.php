<?php
namespace Jesh\Helpers;

Class PermissionHelper
{
    public static function HasUserPageAccess(
        $base_url, $is_finance_page = false
    )
    {
        $flags = json_decode(Session::Get("user_data"), true)["flags"];

        if(!$flags["is_batch_member"])
        {
            self::Redirect($base_url."request/batch");
        }
        else if(!$flags["is_committee_member"] && !$flags["is_frontman"]) 
        {
            self::Redirect($base_url."request/committee");
        }
        else if($is_finance_page && !$flags["is_finance"])
        {
            self::Redirect($base_url);
        }

        return true;
    }

    

    private static function Redirect($url)
    {
        header("Location: " . $url);
        exit();
    }
}