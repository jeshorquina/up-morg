<?php
namespace Jesh\Helpers;

use \Jesh\Helpers\Session;

Class UserSession
{
    public static function GetBatchMemberID()
    {
        return self::GetSessionData()["batch"]["member_id"];
    }

    private static function GetSessionData()
    {
        return json_decode(Session::Get("user_data"), true);
    }
}