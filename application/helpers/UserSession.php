<?php
namespace Jesh\Helpers;

class UserSession
{
    public static function GetBatchID()
    {
        return self::GetSessionData()["batch"]["id"];
    }

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

    public static function IsBatchMember()
    {
        return (bool) self::GetSessionData()["flags"]["is_batch_member"];
    }

    private static function GetSessionData()
    {
        if(Session::Find("user_data"))
        {
            return json_decode(Session::Get("user_data"), true);
        }
        else 
        {
            Http::Response(
                Http::FOUND,
                "Successfully logged out.",
                "Location: " . base_url()
            );
        }
    }
}
