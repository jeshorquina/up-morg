<?php
namespace Jesh\Helpers;

use \Jesh\Helpers\Session;

class UserSession
{
    public static function GetBatchMemberID()
    {
        return self::GetSessionData()["batch"]["member_id"];
    }

    public static function IsFirstFrontman()
    {
        return (bool) self::GetSessionData()["flags"]["is_first_frontman"];
    }

    public static function IsFrontman()
    {
        return (bool) self::GetSessionData()["flags"]["is_frontman"];
    }

    public static function IsCommitteeHead()
    {
        return (bool) self::GetSessionData()["flags"]["is_committee_head"];
    }

    public static function IsCommitteeMember()
    {
        return (bool) self::GetSessionData()["flags"]["is_committee_member"];
    }

    public static function IsFinanceMember()
    {
        return (bool) self::GetSessionData()["flags"]["is_finance"];
    }

    private static function GetSessionData()
    {
        return json_decode(Session::Get("user_data"), true);
    }
}