<?php
namespace Jesh\Helpers;

class UserSession
{
    public static function GetBatchID()
    {
        $batch = self::GetSessionData()["batch"];
        if(array_key_exists("id", $batch))
        {
            return $batch["id"];
        }
        else
        {
            return false;
        }
    }

    public static function GetCommitteeID()
    {
        $committee = self::GetSessionData()["committee"];
        if(array_key_exists("id", $committee))
        {
            return $committee["id"];
        }
        else
        {
            return false;
        }
    }

    public static function GetBatchMemberID()
    {
        $batch = self::GetSessionData()["batch"];
        if(array_key_exists("member_id", $batch))
        {
            return $batch["member_id"];
        }
        else
        {
            return false;
        }
    }
    
    public static function GetMemberTypeID()
    {
        $batch = self::GetSessionData()["batch"];
        if(array_key_exists("member_type_id", $batch))
        {
            return $batch["member_type_id"];
        }
        else
        {
            return false;
        }
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
                "Session data expired.",
                "Location: " . base_url('action/logout')
            );
        }
    }
}
