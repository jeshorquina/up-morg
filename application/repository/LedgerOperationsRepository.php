<?php
namespace Jesh\Repository;

use \Jesh\Core\Wrappers\Repository;

use \Jesh\Models\StaticDataModel;

class LedgerOperationsRepository extends Repository
{
    public function GetLedgerEntries()
    {
        return self::Get("LedgerInput", "*");
    }

    public function IsLedgerActivated()
    {
        return self::Get(
            "StaticData", "Value", array("Name" => "IsLedgerActivated")
        );
    }

    public function ToggleLedger(StaticDataModel $static_data)
    {
        return self::Update(
            "StaticData", array("Name" => "IsLedgerActivated"), $static_data
        );
    }
}